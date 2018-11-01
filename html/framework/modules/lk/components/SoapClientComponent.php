<?php

namespace app\modules\lk\components;

use app\modules\lk\components\transport\ImportTransportInterfaceLk;
use app\modules\lk\dto\FileDto;
use Yii;
use yii\base\Component;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\imagine\Image;

/**
 * Class SoapClientComponent
 * @package app\modules\lk\components
 */
class SoapClientComponent extends Component
{
    const TMP_DIR = '@app/runtime/tmp';
    const LK_FILES = '@webroot/uploads/lkFiles';
    const LK_URL = '/uploads/lkFiles';
    const PHOTO_HEIGHT = 200;
    const PHOTO_WIDTH = 200;

    const EXISTS_DOCUMENTS_YES = 1;
    const EXISTS_DOCUMENTS_NO = 0;
    const DOCUMENT_SCHET = 'DocSchet';
    const DOCUMENT_TTN = 'DocTTN';
    const DOCUMENT_UPD = 'DocUPD';

    /**
     * Статусы заказов с 1С
     */

    const ORDER_CREATE = 0;
    const ORDER_RESERVE = 1;
    const ORDER_FEATURE = 2;
    const ORDER_READY = 3;
    const ORDER_SHIPPED = 4;

    public static $orders = [
        self::ORDER_CREATE => 'Создан',
        self::ORDER_RESERVE => 'Зарезервирован',
        self::ORDER_FEATURE => 'Собирается',
        self::ORDER_READY => 'Готов к отгрузке',
        self::ORDER_SHIPPED => 'Отгружен',
    ];
    public static $ordersImport = [
        self::ORDER_CREATE => [
            'Заказ создан',
            'К согласованию',
            'Отправлен клиенту',
            'Согласован с клиентом',
        ],
        self::ORDER_RESERVE => [
            'Заказ проведен',
        ],
        self::ORDER_FEATURE => [
            'К отгрузке',
            'В работе',
        ],
        self::ORDER_READY => [
            'Набран',
        ],
        self::ORDER_SHIPPED => [
            'Отгружен',
        ],
    ];

    /**
     * @var ImportTransportInterfaceLk
     */
    protected $transport;

    protected $pathUser;
    protected $urlUser;

    /**
     * SoapClientComponent constructor.
     *
     * @param ImportTransportInterfaceLk $transport
     * @param array $config
     *
     */
    public function __construct(ImportTransportInterfaceLk $transport, array $config = [])
    {
        parent::__construct($config);

        // create tmp dir for import files
        if (!is_dir(Yii::getAlias(self::TMP_DIR))) {
            FileHelper::createDirectory(Yii::getAlias(self::TMP_DIR));
        }

        if (!is_dir(Yii::getAlias(self::LK_FILES))) {
            FileHelper::createDirectory(Yii::getAlias(self::LK_FILES));
        }

        $this->transport = $transport;
    }

    /**
     * @param $login
     * @param $password
     * @return array
     */
    public function login($login, $password)
    {
        $data = [];
        if ($this->transport->call('GetUser', ['Login' => $login, 'Password' => $password])) {
            /*$fh = fopen(Yii::getAlias('@webroot') . '/GetUser.xml', 'wb');
            fwrite($fh, $this->transport->getBinaryData());
            fclose($fh);*/
            $transport = $this->transport->getXml();
            if ($transport->getElementsByTagName('SiteDataExport')->item(0)->getAttribute('LogInAllowed') == 'yes') {
                $export = $transport->getElementsByTagName('SiteDataExport')->item(0);

                $this->pathUser = Yii::getAlias(self::LK_FILES) . DIRECTORY_SEPARATOR . $export->getAttribute('UID');
                $this->urlUser = self::LK_URL . DIRECTORY_SEPARATOR . $export->getAttribute('UID');

                $this->unlinkRecursive($this->pathUser);

                if (!is_dir($this->pathUser)) {
                    mkdir($this->pathUser);
                }

                $data['uid'] = $export->getAttribute('UID');
                $data['fio'] = $export->getAttribute('FIO');
                $data['partner']['uid'] = $export->getAttribute('PartnerUID');
                $data['partner']['name'] = $export->getAttribute('Partner');
                $data['manager']['uid'] = $export->getAttribute('ManagerUID');
                $data['manager']['name'] = $export->getAttribute('Manager');
                $data['balance'] = $export->getAttribute('Debt');
                $data['login'] = $login;
                $data['password'] = $password;

                if ($transport->getElementsByTagName('PartnerContacts')->length > 0) {
                    $partner = $transport->getElementsByTagName('PartnerContacts')->item(0);
                    if ($partner->getElementsByTagName('Contact')->length > 0) {
                        /**
                         * @var int $key
                         * @var \DOMElement $value
                         */
                        foreach ($partner->getElementsByTagName('Contact') as $key => $value) {
                            if ($value->getAttribute('Type') == 'Телефон') {
                                $data['partner']['tel'] = $value->getAttribute('Value');
                            }
                            if ($value->getAttribute('Type') == 'Мобильный телефон') {
                                $data['partner']['mobile'] = $value->getAttribute('Value');
                            }
                            if ($value->getAttribute('Type') == 'Электронная почта') {
                                $data['partner']['email'] = $value->getAttribute('Value');
                            }
                        }
                    }
                }

                if ($transport->getElementsByTagName('Contractors')->length > 0) {
                    $agent = $transport->getElementsByTagName('Contractors')->item(0);
                    if ($agent->getElementsByTagName('Contractor')->length > 0) {
                        foreach ($agent->getElementsByTagName('Contractor') as $key => $value) {
                            $data['agent'][$key]['uid'] = $value->getAttribute('UID');
                            $data['agent'][$key]['name'] = $value->getAttribute('LegalName');
                            $data['agent'][$key]['urAdress'] = $value->getAttribute('UrAdres');
                            $data['agent'][$key]['urAdress'] = $value->getAttribute('GruzAdres');
                        }
                    }
                }

                if ($transport->getElementsByTagName('ManagerContacts')->length > 0) {
                    $manager = $transport->getElementsByTagName('ManagerContacts')->item(0);
                    if ($manager->getElementsByTagName('Contact')->length > 0) {
                        foreach ($manager->getElementsByTagName('Contact') as $key => $value) {
                            if ($value->getAttribute('Type') == 'Телефон') {
                                $data['manager']['tel'] = $value->getAttribute('Value');
                            }
                            if ($value->getAttribute('Type') == 'Мобильный телефон') {
                                $data['manager']['mobile'] = $value->getAttribute('Value');
                            }
                            if ($value->getAttribute('Type') == 'Электронная почта') {
                                $data['manager']['email'] = $value->getAttribute('Value');
                            }
                        }
                    }
                }

                if ($transport->getElementsByTagName('ManagerPhoto')->length > 0) {
                    $photo = $this->getFile($this->createFileDtoFromNode($transport->getElementsByTagName('ManagerPhoto')->item(0)), $this->pathUser);
                    $data['manager']['photo'] = $this->urlUser . DIRECTORY_SEPARATOR . $photo->getUid() . '.' . $photo->getExtension();
                }
                $orders = $this->getOrders($export->getAttribute('PartnerUID'), '');

                if (!empty($orders)) {
                    $data = ArrayHelper::merge($data, $orders);
                }
            }
        }
        return $data;
    }

    /**
     * @param $orderUid
     * @param $docType
     * @param $userUid
     * @return array|bool
     */
    public function getOrderDocs($orderUid, $docType, $userUid)
    {
        $data = [];
        if ($this->transport->call('GetOrderDocs', ['OrderUID' => $orderUid, 'DocType' => $docType])) {
            $file = $this->transport->getFilePdf();
            if (isset($file->BinaryData)) {
                $path = Yii::getAlias(self::LK_FILES) . DIRECTORY_SEPARATOR . $userUid . DIRECTORY_SEPARATOR . $file->Name . '.' . $file->Extension;
                $url = self::LK_URL . DIRECTORY_SEPARATOR . $userUid . DIRECTORY_SEPARATOR . $file->Name . '.' . $file->Extension;

                if(!file_exists($path)) {
                    $fh = fopen($path, 'wb');
                    fwrite($fh, $file->BinaryData);
                    fclose($fh);
                }
                $data['url'] = $url;
                $data['ext'] = pathinfo($path);
                $data['size'] = filesize($path);
                return $data;
                //$data['order'][$key]['docs']['DocSchet'][] = $this->urlUser . DIRECTORY_SEPARATOR . $file->Name . '.' . $file->Extension;
            }
        }
        return false;
    }

    /**
     * @param $partnerUid
     * @param string $orderUid
     * @return array
     */
    private function getOrders($partnerUid, $orderUid = '')
    {
        $data['orders'] = [];
        if ($this->transport->call('GetOrders', ['PartnerUID' => $partnerUid, 'OrderUID' => $orderUid])) {
            $transport = $this->transport->getXml();
            /*$fh = fopen(Yii::getAlias('@webroot') . '/GetOrders.xml', 'wb');
            fwrite($fh, $this->transport->getBinaryData());
            fclose($fh);*/

            if ($transport->getElementsByTagName('SiteDataExport')->item(0)) {
                if ($transport->getElementsByTagName('Order')->length > 0) {
                    /**
                     * @var int $key
                     * @var \DOMElement $value
                     */
                    foreach ($transport->getElementsByTagName('Order') as $key => $value) {
                        $data['orders'][$key]['documents']['exists'] = self::EXISTS_DOCUMENTS_NO;
                        if ($value->getAttribute('ExistDocuments') == 'yes') {
                            $data['orders'][$key]['documents']['exists'] = self::EXISTS_DOCUMENTS_YES;
                            if ($value->getAttribute('ExistDocSchet') == 'yes') {
                                $data['orders'][$key]['documents'][self::DOCUMENT_SCHET] = '';
                            }
                            if ($value->getAttribute('ExistDocUPD') == 'yes') {
                                $data['orders'][$key]['documents'][self::DOCUMENT_UPD] = '';
                            }
                            if ($value->getAttribute('ExistDocTNN') == 'yes') {
                                $data['orders'][$key]['documents'][self::DOCUMENT_TTN] = '';
                            }
                        } else {
                            $data['orders'][$key]['documents']['exists'] = self::EXISTS_DOCUMENTS_NO;
                        }

                        $data['orders'][$key]['uid'] = $value->getAttribute('UID');
                        $data['orders'][$key]['partnerName'] = $value->getAttribute('Partner');
                        $data['orders'][$key]['partnerUid'] = $value->getAttribute('PartnerUID');
                        $data['orders'][$key]['contractorName'] = $value->getAttribute('Contractor');
                        $data['orders'][$key]['contractorUid'] = $value->getAttribute('ContractorUID');
                        $data['orders'][$key]['managerName'] = $value->getAttribute('Manager');
                        $data['orders'][$key]['managerUid'] = $value->getAttribute('ManagerUID');
                        $data['orders'][$key]['orderNumber'] = $value->getAttribute('OrderNumber');
                        $data['orders'][$key]['shippingDate'] = $value->getAttribute('ShippingDate');
                        $data['orders'][$key]['gruzAddress'] = $value->getAttribute('GruzAddress');

                        $status = $value->getAttribute('OrderStatus');
                        $result = array_filter(self::$ordersImport, function ($value) use ($status) {
                            if (in_array($status, $value)) {
                                return $value;
                            }
                            return false;
                        });

                        if (!empty($result)) {

                            $data['orders'][$key]['statusName'] = self::$orders[key($result)];
                            $data['orders'][$key]['status'] = key($result);
                        } else {
                            $data['orders'][$key]['status'] = null;
                            $data['orders'][$key]['statusName'] = '';
                        }


                        $data['orders'][$key]['totalSum'] = str_replace(',', '.', $value->getAttribute('OrderTotalSum'));
                        $data['orders'][$key]['totalUnit'] = $value->getAttribute('OrderTotalUnit');
                        $data['orders'][$key]['totalBox'] = $value->getAttribute('OrderTotalBox');
                        $data['orders'][$key]['createdAtDateTime'] = $value->getAttribute('OrderCreationDate');
                        $data['orders'][$key]['createdAtDate'] = date('Y-m-d', strtotime($value->getAttribute('OrderCreationDate')));
                        $data['orders'][$key]['updatedAtDateTime'] = $value->getAttribute('OrderModificationDate');
                        $data['orders'][$key]['updatedAtDate'] = date('Y-m-d', strtotime($value->getAttribute('OrderModificationDate')));


                    }
                }
            }
        }
        return $data;
    }

    /**
     * @param \DOMElement $fileNode
     *
     * @return FileDto
     */
    protected function createFileDtoFromNode(\DOMElement $fileNode)
    {
        return new FileDto([
            'uid' => $fileNode->getAttribute('FileUID'),
            'type' => $fileNode->nodeName,
            'title' => $fileNode->getAttribute('Description'),
            'size' => $fileNode->getAttribute('FileSizeDB'),
            'extension' => $fileNode->getAttribute('Extension'),
            'createdAt' => $fileNode->getAttribute('CreationDate'),
            'updatedAt' => $fileNode->getAttribute('ModificationDate'),
            'deleted' => $fileNode->getAttribute('FileDeleted') == 'yes' ? 1 : 0,
        ]);
    }

    /**
     * @param FileDto $file
     * @param $path
     * @return FileDto|bool
     */
    public function getFile(FileDto $file, $path)
    {
        if (empty($file->getUid())) {
            return false;
        }

        $tempPath = Yii::getAlias(self::TMP_DIR);
        $tempPath .= DIRECTORY_SEPARATOR . $file->getUid() . '.' . $file->getExtension();

        //$path = Yii::getAlias(self::LK_FILES) . DIRECTORY_SEPARATOR . $file->getUid() . '.' . $file->getExtension();


        if (file_exists($path) && filesize($path) == $file->getSize() && basename($path) == $file->getUid() . '.' . $file->getExtension()) {
            $file->setPath($path);
            return $file;
        }

        if ($this->transport->call('GetFile', [
            'FileUID' => $file->getUid(),
            'FileType' => $file->getType(),
            'FileName' => '',
            'FileExtension' => '',
        ])) {
            $fh = fopen($tempPath, 'wb');
            fwrite($fh, $this->transport->getBinaryData());
            fclose($fh);
            Image::thumbnail($tempPath, self::PHOTO_WIDTH, self::PHOTO_HEIGHT)->save($path . DIRECTORY_SEPARATOR . $file->getUid() . '.' . $file->getExtension(), ['quality' => 80]);
            unlink($tempPath);
            $file->setPath($path);
            return $file;
        }
        return false;
    }

    /**
     * remove directory with tmp files
     */
    public function clearFiles()
    {
        $path = Yii::getAlias(self::TMP_DIR);
        if (is_dir($path)) {
            FileHelper::removeDirectory($path);
        }
    }

    private function unlinkRecursive($path)
    {
        if (is_dir($path) === true) {
            $files = array_diff(scandir($path), array('.', '..'));

            foreach ($files as $file) {
                $this->unlinkRecursive(realpath($path) . '/' . $file);
            }

            return rmdir($path);
        } else if (is_file($path) === true) {
            return unlink($path);
        }

        return false;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 14.07.17
 * Time: 11:27
 */

namespace app\modules\product\components;

use app\modules\product\components\transport\ImportTransportInterface;
use app\modules\product\dto\BaseDto;
use app\modules\product\dto\BrandDto;
use app\modules\product\dto\ClientCategoryDto;
use app\modules\product\dto\FileDto;
use app\modules\product\dto\ParamDto;
use app\modules\product\dto\ProductDto;
use app\modules\product\dto\ProductSetDto;
use app\modules\product\dto\ProductSetItemDto;
use app\modules\product\dto\PromoDto;
use app\modules\product\dto\PropertyDto;
use app\modules\product\dto\SectionDto;
use app\modules\product\dto\UsageDto;
use Yii;
use yii\base\Component;
use yii\helpers\FileHelper;

/**
 * Class SoapClientComponent
 *
 * @package app\modules\product\components
 */
class SoapClientComponent extends Component
{
    const TMP_DIR = '@app/runtime/tmp';

    /**
     * @var array
     */
    protected $errors = [];

    /**
     * @var ImportTransportInterface
     */
    protected $transport;

    /**
     * SoapClientComponent constructor.
     *
     * @param ImportTransportInterface $transport
     * @param array $config
     *
     */
    public function __construct(ImportTransportInterface $transport, array $config = [])
    {
        parent::__construct($config);

        // create tmp dir for import files
        if (!is_dir(Yii::getAlias(self::TMP_DIR))) {
            FileHelper::createDirectory(Yii::getAlias(self::TMP_DIR));
        }

        $this->transport = $transport;
    }

    /**
     * @return bool|BrandDto[]
     */
    public function getBrands()
    {
        if ($this->transport->call('GetReferences', [])) {
            /*<Brand Name="AVIORA" BrandDescription="" BrandFullDescription="" Position="0" UID="f7ed6a1f-f456-11e7-b64b-3464a931ea12" ElementDeleted="no">
                <Files>
                    <BrandLogo Description="Penguins" Extension="jpg" FileUID="5c41f39f-08d8-11e8-b287-5442497078ec" FileSizeDB="777835" CreationDate="2018-02-03 14:50:55" ModificationDate="2009-07-14 05:32:31" FileDeleted="yes"/>
                    <BrandPresentation Description="Penguins" Extension="jpg" FileUID="5c41f3a0-08d8-11e8-b287-5442497078ec" FileSizeDB="777835" CreationDate="2018-02-03 14:53:04" ModificationDate="2009-07-14 05:32:31" FileDeleted="no"/>
                </Files>
            </Brand>*/
            $list = [];

            /** @var \DOMElement $item */
            foreach ($this->transport->getXml()->getElementsByTagName('Brand') as $item) {
                $dto = new BrandDto([
                    'uid' => $item->getAttribute('UID'),
                    'title' => $item->getAttribute('Name'),
                    'deleted' => $item->getAttribute('ElementDeleted') == 'yes' ? 1 : 0,
                    'description' => $item->getAttribute('BrandDescription'),
                    'text' => $item->getAttribute('BrandFullDescription'),
                    'position' => (int)$item->getAttribute('Position'),
                ]);

                // brand logo
                if ($item->getElementsByTagName('BrandLogo')->length > 0) {
                    $logo = $this->createFileDtoFromNode($item
                        ->getElementsByTagName('BrandLogo')->item(0)
                    );

                    if ($this->getFile($logo)) {
                        $dto->setLogo($logo);
                    }
                }
                if ($item->getElementsByTagName('BrandPresentation')->length > 0) {
                    $presentation = $this->createFileDtoFromNode($item
                        ->getElementsByTagName('BrandPresentation')->item(0)
                    );

                    if ($this->getFile($presentation)) {
                        $dto->setPresentation($presentation);
                    }
                }
                array_push($list, $dto);
            }

            return $list;
        }

        return false;
    }

    /**
     * @return bool|UsageDto[]
     */
    public function getUsages()
    {
        if ($this->transport->call('GetReferences', [])) {
            /*<Usage Name="Для ухода за одеждой и обувью" Position="0" UID="14b0c5ee-1714-11e8-a22d-d0946606ab89" ElementDeleted="no">
                <Files>
                    <UsagePicture Description="04-clothes" Extension="svg" FileUID="4cb289a3-34ec-11e8-a231-d0946606ab89" FileSizeDB="1578" CreationDate="2018-03-31 17:03:34" ModificationDate="2018-03-28 10:38:02" FileDeleted="no"/>
                </Files>
            </Usage>*/
            $list = [];

            /** @var \DOMElement $item */
            foreach ($this->transport->getXml()->getElementsByTagName('Usage') as $item) {
                $dto = new UsageDto([
                    'uid' => $item->getAttribute('UID'),
                    'title' => $item->getAttribute('Name'),
                    'position' => (int)$item->getAttribute('Position'),
                    'deleted' => $item->getAttribute('ElementDeleted') == 'yes' ? 1 : 0,
                ]);

                // icon
                if ($item->getElementsByTagName('UsagePicture')->length > 0) {
                    $icon = $this->createFileDtoFromNode($item
                        ->getElementsByTagName('UsagePicture')->item(0)
                    );

                    if ($this->getFile($icon)) {
                        $dto->setIcon($icon);
                    }
                }
                array_push($list, $dto);
            }

            return $list;
        }

        return false;
    }


    /**
     * @return bool|ClientCategoryDto[]
     */
    public function getClientCategories()
    {
        if ($this->transport->call('GetReferences', [])) {
            /*<ClientCategory Name="Розничный покупатель" UID="c69e346f-4dc7-4069-a6dd-4c97c6023c93" ElementDeleted="No">
				<Files>
					<ClientCategoryPicture Description="logo" Extension="png" FileUID="0eb96a89-873b-11e7-91ba-c4850810e13a" FileSizeDB="39286" CreationDate="2018-01-22" CreationTime="10:59:20" ModificationDate="2018-01-22" ModificationTime="10:59:59" FileDeleted="No"/>
				</Files>
			</ClientCategory>*/
            $list = [];

            /** @var \DOMElement $item */
            foreach ($this->transport->getXml()->getElementsByTagName('ClientCategory') as $item) {
                $dto = new ClientCategoryDto([
                    'uid' => $item->getAttribute('UID'),
                    'title' => $item->getAttribute('Name'),
                    'deleted' => $item->getAttribute('ElementDeleted') == 'yes' ? 1 : 0,
                ]);

                // icon
                if ($item->getElementsByTagName('ClientCategoryPicture')->length > 0) {
                    $icon = $this->createFileDtoFromNode($item
                        ->getElementsByTagName('ClientCategoryPicture')->item(0)
                    );

                    if ($this->getFile($icon)) {
                        $dto->setIcon($icon);
                    }
                }
                array_push($list, $dto);
            }

            return $list;
        }

        return false;
    }

    /**
     * @return bool|SectionDto[]
     */
    public function getSections()
    {
        if ($this->transport->call('GetReferences', [])) {
            /*<Section Name="Перчатки" ParentUID="00000000-0000-0000-0000-000000000000" Position="14" UID="fb4554c8-489f-11e8-a23a-d0946606ab89" ElementDeleted="no" BrandUID="f7ed6a1f-f456-11e7-b64b-3464a931ea12">
                <SectionBrand Brand="AVIORA" BrandUID="f7ed6a1f-f456-11e7-b64b-3464a931ea12"/>
                <SectionBrand Brand="Paterra" BrandUID="fdf59b3e-f456-11e7-b64b-3464a931ea12"/>
                <SectionBrand Brand="Горница" BrandUID="1aa6ba47-f457-11e7-b64b-3464a931ea12"/>
            </Section>
            <Section Name="Пищевые плёнки" ParentUID="00000000-0000-0000-0000-000000000000" Position="39" UID="70e47eaa-5d06-11e8-a23c-d0946606ab89" ElementDeleted="no" BrandUID="35a1ec5e-f457-11e7-b64b-3464a931ea12">
                <SectionBrand Brand="ДЕСНОГОР" BrandUID="35a1ec5e-f457-11e7-b64b-3464a931ea12"/>
                <SectionBrand Brand="Paterra" BrandUID="fdf59b3e-f456-11e7-b64b-3464a931ea12"/>
                <SectionBrand Brand="AVIORA" BrandUID="f7ed6a1f-f456-11e7-b64b-3464a931ea12"/>
            </Section>
            */
            $list = [];
            /** @var \DOMElement $item */
            foreach ($this->transport->getXml()->getElementsByTagName('Section') as $item) {
                $dto = new SectionDto([
                    'uid' => $item->getAttribute('UID'),
                    'title' => $item->getAttribute('Name'),
                    'deleted' => $item->getAttribute('ElementDeleted') == 'yes' ? 1 : 0,
                    'position' => (int)$item->getAttribute('Position'),
                    'parentUid' => $item->getAttribute('ParentUID'),
                ]);
                // add section rel

                if ($item->getElementsByTagName('SectionBrand')->length > 0) {
                    /** @var \DOMElement[] $brands */
                    $brands = $item->getElementsByTagName('SectionBrand');
                    foreach ($brands as $brand) {
                        $dto->addBrand(new BrandDto([
                            'uid' => (string)$brand->getAttribute('BrandUID'),
                            'title' => (string)$brand->getAttribute('Brand'),
                        ]));
                    }
                } else {
                    $dto->addBrand(new BaseDto([
                        'uid' => (string)$item->getAttribute('BrandUID'),
                    ]));

                }

                array_push($list, $dto);
            }

            return $list;
        }

        return false;
    }

    /**
     * @param string $uid
     *
     * @return bool|ProductDto
     */
    public function getProduct(string $uid)
    {
        if ($this->transport->call('GetProduct', ['ProductUID' => $uid])) {
            /*
              <Product Active="yes" Article="403-197"
                     PrintName="Универсальный БЫСТРЫЙ клей &quot;СЕКУНДА&quot; 30 мл (10 шт. в шоу-боксе)"
                     SiteName="Универсальный БЫСТРЫЙ клей, 30 мл"
                     ProductSummary="Универсальный клей предназначен для соединения металла, ПВХ, полистирола, резины, войлока, кожи и др"
                     ProductFullDescription="Клей универсальный особопрочный применяется для склеивания резины , кожи, дерева, пластиков, кортона, ткани, керамики, пробки и прочих устойчивых к растворителям материалов, образуя при этом клеевой шов, устойчивый к морской и пресной воде, не вызывающий коррозии стали и алюминиевых сплавов и сохраняющий свои свойства от -50С до +70С."
                     Weight="45" WeightUnit="г" BoxQuantity="60" Unit="шт" BestBefore="указан на упаковке" BoxLenght="43"
                     BoxWidth="22" BoxHeight="18" Material="полихлоропреновые каучуки, смолы, растворители, ок"
                     UID="fdf59b20-f456-11e7-b64b-3464a931ea12" ElementDeleted="no" Brand="Секунда"
                     BrandUID="fdf59ae5-f456-11e7-b64b-3464a931ea12" Section="Универсальные клеи"
                     SectionUID="b647f17e-21e5-11e8-a22e-d0946606ab89">
                <ClientCategories>
                    <ClientCategory Name="Розничный покупатель" UID="e96d8a88-1710-11e8-a22d-d0946606ab89"/>
                    <ClientCategory Name="Бизнес и производство" UID="a4ec364d-1712-11e8-a22d-d0946606ab89"/>
                </ClientCategories>
                <Usages>
                    <Usage Name="Для строительства и ремонта" UID="7aa914af-1712-11e8-a22d-d0946606ab89"/>
                </Usages>
                <Advantages>
                    <Advantage Name="Удлиненный носик "/>
                    <Advantage Name=" Водостойкость"/>
                    <Advantage Name="Вермя фиксации 5 минут"/>
                </Advantages>
                <ProductVideos/>
                <AdditionalParams>
                    <AddParam Param="Размер" Value="30 мл"/>
                    <AddParam Param="Цвет" Value="прозрачный"/>
                    <AddParam Param="Материал" Value="полихлоропреновые каучуки, растворители"/>
                    <AddParam Param="Диапазон рабочих температур" Value="от -50 С до +70 С"/>
                </AdditionalParams>
                <RelatedProducts>
                    <RelatedProduct Product="Моментальный клей 3 г. + антиклей 3г., блистер, шоу-бокс 24шт., СЕКУНДА /72"
                                    Article="403-214" UID="35a1ed17-f457-11e7-b64b-3464a931ea12"/>
                </RelatedProducts>
            </Product>
             */

            /** @var \DOMElement $item */
            if ($this->transport->getXml()->getElementsByTagName('Product')->length > 0) {
                $item = $this->transport->getXml()->getElementsByTagName('Product')->item(0);

                $dto = new ProductDto([
                    'uid' => $item->getAttribute('UID'),
                    'brandUid' => $item->getAttribute('BrandUID'),
                    'article' => $item->getAttribute('Article'),
                    'title' => $item->getAttribute('SiteName'),
                    'printableTitle' => $item->getAttribute('PrintName'),
                    'description' => $item->getAttribute('ProductSummary'),
                    'text' => $item->getAttribute('ProductFullDescription'),
                    'active' => $item->getAttribute('Active') == 'yes' ? 1 : 0,
                    'deleted' => $item->getAttribute('ElementDeleted') == 'yes' ? 1 : 0,
                    'createdAt' => $item->getAttribute('CreationDate'),
                    'updatedAt' => $item->getAttribute('ModificationDate'),
                ]);

                // fill product properties
                foreach (PropertyDto::$staticProperties as $property => $title) {
                    if ($item->getAttribute($property) > '') {
                        $propertyDto = new PropertyDto([
                            'code' => $property,
                            'title' => $title,
                            'value' => $item->getAttribute($property),
                        ]);

                        if ($property == 'Weight') {
                            $propertyDto->setUnit($item->getAttribute('WeightUnit'));
                        } elseif ($property == 'BoxQuantity') {
                            $propertyDto->setUnit($item->getAttribute('Unit'));
                        } elseif (in_array($property, ['BoxLenght', 'BoxWidth', 'BoxHeight'])) {
                            $propertyDto->setUnit('см');
                        }

                        $dto->addProperty($propertyDto);
                    }
                }
                // set product sections
                $dto->addSection($item->getAttribute('SectionUID'));

                // set product usages
                /** @var \DOMElement[] $usages */
                if ($usages = $item->getElementsByTagName('Usage')) {
                    foreach ($usages as $usage) {
                        $dto->addUsage($usage->getAttribute('UID'));
                    }
                }

                // set product client categories
                /** @var \DOMElement[] $categories */
                if ($categories = $item->getElementsByTagName('ClientCategory')) {
                    foreach ($categories as $category) {
                        $dto->addClientCategory($category->getAttribute('UID'));
                    }
                }

                // set product advantages
                /** @var \DOMElement[] $advantages */
                if ($advantages = $item->getElementsByTagName('Advantage')) {
                    foreach ($advantages as $advantage) {
                        $dto->addAdvantage($advantage->getAttribute('Name'));
                    }
                }

                // set videos
                /** @var \DOMElement[] $videos */
                if ($videos = $item->getElementsByTagName('ProductVideo')) {
                    foreach ($videos as $video) {
                        $dto->addVideo($video->getAttribute('Name'));
                    }
                }

                /** @var \DOMElement[] $params */
                if ($params = $item->getElementsByTagName('AddParam')) {
                    foreach ($params as $param) {
                        $dto->addParam(new ParamDto([
                            'title' => $param->getAttribute('Param'),
                            'value' => $param->getAttribute('Value'),
                        ]));
                    }
                }

                // set related products
                /** @var \DOMElement[] $related */
                if ($related = $item->getElementsByTagName('RelatedProduct')) {
                    foreach ($related as $product) {
                        $dto->addRelatedProduct($product->getAttribute('UID'));
                    }
                }

                return $dto;
            }
        }

        return false;
    }

    /**
     * @return bool|ProductDto[]
     */
    public function getActiveProducts()
    {
        if ($this->transport->call('GetReferences', [])) {
            /* <Product Article="303-005" ModificationDate="2018-02-07 09:20:27" UID="f7ed6a20-f456-11e7-b64b-3464a931ea12"
                 ElementDeleted="no">
            <Files>
                <ProductDoc Description="Lighthouse" Extension="jpg" FileUID="f6c34883-09bc-11e8-b287-5442497078ec"
                            FileSizeDB="561276" CreationDate="2018-02-04 18:10:27"
                            ModificationDate="2009-07-14 05:32:31" FileDeleted="no"/>
            </Files>
        </Product>*/
            $list = [];

            /** @var \DOMElement $item */
            foreach ($this->transport->getXml()->getElementsByTagName('Product') as $item) {
                $dto = new ProductDto([
                    'uid' => $item->getAttribute('UID'),
                    'title' => $item->getAttribute('Name'),
                    'active' => $item->getAttribute('Active') == 'yes' ? 1 : 0,
                    'deleted' => $item->getAttribute('ElementDeleted') == 'yes' ? 1 : 0,
                    'createdAt' => $item->getAttribute('CreationDate'),
                    'updatedAt' => $item->getAttribute('ModificationDate'),
                ]);

                if ($documents = $item->getElementsByTagName('ProductDoc')) {
                    foreach ($documents as $document) {
                        $fileDto = $this->createFileDtoFromNode($document);
                        if ($this->getFile($fileDto)) {
                            $dto->addDocument($fileDto);
                        }
                    }
                }
                if ($images = $item->getElementsByTagName('ProductPicture')) {
                    foreach ($images as $image) {
                        $fileDto = $this->createFileDtoFromNode($image);
                        if ($this->getFile($fileDto)) {
                            $dto->addImage($fileDto);
                        }
                    }
                }

                array_push($list, $dto);
            }

            return $list;
        }

        return false;
    }

    /**
     * @return bool|PromoDto[]
     */
    public function getPromos()
    {
        if ($this->transport->call('GetReferences', [])) {
            /*<Promo Colour="ffff00" Name="Новинки" Position="1" UID="b084562b-09c1-11e8-b287-5442497078ec" ElementDeleted="no">
                <PromoArticles>
                    <PromoArticle Article="305-005" UID="fdf59ab5-f456-11e7-b64b-3464a931ea12"/>
                    <PromoArticle Article="403-052" UID="fdf59b1e-f456-11e7-b64b-3464a931ea12"/>
                </PromoArticles>
                <Files>
                    <PromoPicture Description="Chrysanthemum" Extension="jpg" FileUID="40bd8d62-09c2-11e8-b287-5442497078ec" FileSizeDB="879394" CreationDate="2018-02-04 18:44:18" ModificationDate="2009-07-14 05:32:31" FileDeleted="no"/>
                </Files>
            </Promo>*/
            $list = [];

            /** @var \DOMElement $item */
            foreach ($this->transport->getXml()->getElementsByTagName('Promo') as $item) {
                $dto = new PromoDto([
                    'uid' => $item->getAttribute('UID'),
                    'title' => $item->getAttribute('Name'),
                    'color' => $item->getAttribute('Colour'),
                    'deleted' => $item->getAttribute('ElementDeleted') == 'yes' ? 1 : 0,
                    'position' => (int)$item->getAttribute('Position'),
                ]);

                // icon
                if ($item->getElementsByTagName('PromoPicture')->length > 0) {
                    $icon = $this->createFileDtoFromNode($item
                        ->getElementsByTagName('PromoPicture')->item(0)
                    );

                    if ($this->getFile($icon)) {
                        $dto->setIcon($icon);
                    }
                }
                // products
                /** @var \DOMElement[] $products */
                if ($products = $item->getElementsByTagName('PromoArticle')) {
                    foreach ($products as $product) {
                        $dto->addProduct($product->getAttribute('UID'));
                    }
                }

                array_push($list, $dto);
            }

            return $list;
        }

        return false;
    }

    /**
     * @return bool|ProductSetDto[]
     */
    public function getProductSets()
    {
        if ($this->transport->call('GetReferences', [])) {
            /* <Set Category="Для небольших магазинов"
                Description="Данный набо поможет Вам сделать отличное предложение всем типам клиентов, а значит - заработать дополнительную прибыль!" Name="Простое решение для стенда на кассе!"
                Article="" Position="6"
                UID="fadb9c5d-1e04-11e8-a22e-d0946606ab89" ElementDeleted="no">
                <SetArticles>
                    <SetArticle Article="302-047" UID="f7ed6a6f-f456-11e7-b64b-3464a931ea12" SetArticleQuantity="0"/>
                    <SetArticle Article="302-111" UID="f7ed6acc-f456-11e7-b64b-3464a931ea12" SetArticleQuantity="0"/>
                    <SetArticle Article="303-005" UID="f7ed6a20-f456-11e7-b64b-3464a931ea12" SetArticleQuantity="0"/>
                </SetArticles>
                <SetVideos/>
                <Files>
                    <SetPicture Description="403-107" Extension="jpg" FileUID="7035f08b-1e05-11e8-a22e-d0946606ab89" FileSizeDB="1071280" CreationDate="2018-03-02 13:35:35" ModificationDate="2017-01-16 10:21:01" FileDeleted="no"/>
                    <SetPresentation Description="стенд_Секунда-Авиора" Extension="pdf" FileUID="76f6c338-1e05-11e8-a22e-d0946606ab89" FileSizeDB="662369" CreationDate="2018-03-02 13:35:46" ModificationDate="2013-12-06 12:31:08" FileDeleted="no"/>
                </Files>
            </Set>*/
            $list = [];

            /** @var \DOMElement $item */
            foreach ($this->transport->getXml()->getElementsByTagName('Set') as $item) {
                $dto = new ProductSetDto([
                    'uid' => $item->getAttribute('UID'),
                    'article' => $item->getAttribute('Article'),
                    'title' => $item->getAttribute('Name'),
                    'description' => $item->getAttribute('Description'),
                    'category' => $item->getAttribute('Category'),
                    'deleted' => $item->getAttribute('ElementDeleted') == 'yes' ? 1 : 0,
                    'position' => (int)$item->getAttribute('Position'),
                ]);

                // set videos
                /** @var \DOMElement[] $videos */
                if ($videos = $item->getElementsByTagName('SetVideo')) {
                    foreach ($videos as $video) {
                        $dto->addVideo($video->getAttribute('Link'));
                    }
                }
                // set images
                /** @var \DOMElement[] $images */
                if ($images = $item->getElementsByTagName('SetPicture')) {
                    foreach ($images as $image) {
                        $fileDto = $this->createFileDtoFromNode($image);
                        if ($this->getFile($fileDto)) {
                            $dto->addImage($fileDto);
                        }
                    }
                }
                // set documents
                /** @var \DOMElement[] $images */
                if ($documents = $item->getElementsByTagName('SetPresentation')) {
                    foreach ($documents as $image) {
                        $fileDto = $this->createFileDtoFromNode($image);
                        if ($this->getFile($fileDto)) {
                            $dto->addDocument($fileDto);
                        }
                    }
                }

                // products
                /** @var \DOMElement[] $products */
                if ($products = $item->getElementsByTagName('SetArticle')) {
                    foreach ($products as $product) {
                        $dto->addProductItem(new ProductSetItemDto([
                            'productUid' => $product->getAttribute('UID'),
                            'quantity' => (int)$product->getAttribute('SetArticleQuantity'),
                        ]));
                    }
                }

                array_push($list, $dto);
            }

            return $list;
        }

        return false;
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
     *
     * @return bool|FileDto
     */
    public function getFile(FileDto $file)
    {
        if (empty($file->getUid())) {
            return false;
        }

        $path = Yii::getAlias(self::TMP_DIR);
        $path .= DIRECTORY_SEPARATOR . md5($file->getUid()) . '.' . $file->getExtension();
        if (file_exists($path)) {
            $file->setPath($path);

            return $file;
        }

        if ($this->transport->call('GetFile', [
            'FileUID' => $file->getUid(),
            'FileType' => $file->getType(),
            'FileName' => '',
            'FileExtension' => '',
        ])) {
            $fh = fopen($path, 'wb');
            fwrite($fh, $this->transport->getBinaryData());
            fclose($fh);
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
            $files = glob(self::TMP_DIR . '/*');
            if ($files) {
                foreach ($files as $file) {
                    @unlink($file);
                }
            }
            FileHelper::removeDirectory($path);
        }
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->transport->getErrors();
    }
}
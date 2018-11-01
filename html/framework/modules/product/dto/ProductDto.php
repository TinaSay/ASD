<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 30.01.18
 * Time: 16:00
 */

namespace app\modules\product\dto;

/**
 * Class ProductDto
 *
 * @package app\modules\product\dto
 */
class ProductDto extends BaseDto
{
    /**
     * @var int
     */
    protected $active = 0;

    /**
     * @var PropertyDto[]
     */
    protected $properties = [];

    /**
     * @var array
     */
    protected $advantages = [];

    /**
     * @var array
     */
    protected $videos = [];

    /**
     * @var  ParamDto[]
     */
    protected $params = [];

    /**
     * @var string
     */
    protected $brandUid = '';

    /**
     * @var array of sections UID
     */
    protected $sections = [];

    /**
     * @var array of usage UID
     */
    protected $usages = [];

    /**
     * @var array of client categories UID
     */
    protected $clientCategories = [];

    /**
     * @var string
     */
    protected $article = '';

    /**
     * @var string
     */
    protected $printableTitle = '';
    /**
     * @var string
     */
    protected $description = '';

    /**
     * @var string
     */
    protected $text = '';

    /**
     * @var array of related products UID
     */
    protected $relatedProducts = [];

    /**
     * @var string
     */
    protected $createdAt = '';

    /**
     * @var string
     */
    protected $updatedAt = '';

    /**
     * @var FileDto[]
     */
    protected $documents = [];

    /**
     * @var null|FileDto[]
     */
    protected $images = [];

    /**
     * @return PropertyDto[]
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    /**
     * @param PropertyDto[] $properties
     */
    public function setProperties(array $properties): void
    {
        $this->properties = $properties;
    }

    /**
     * @param PropertyDto $property
     */
    public function addProperty(PropertyDto $property)
    {
        array_push($this->properties, $property);
    }

    /**
     * @return array
     */
    public function getAdvantages(): array
    {
        return $this->advantages;
    }

    /**
     * @param string $advantage
     */
    public function addAdvantage(string $advantage)
    {
        array_push($this->advantages, trim($advantage));
    }

    /**
     * @param array $advantages
     */
    public function setAdvantages(array $advantages): void
    {
        $this->advantages = $advantages;
    }

    /**
     * @return string
     */
    public function getBrandUid(): string
    {
        return $this->brandUid !== '00000000-0000-0000-0000-000000000000' ? $this->brandUid : '';
    }

    /**
     * @param string $brand
     */
    public function setBrandUid(string $brand): void
    {
        $this->brandUid = $brand;
    }

    /**
     * @return array
     */
    public function getSections(): array
    {
        return $this->sections;
    }

    /**
     * @param array
     */
    public function setSections(array $sections): void
    {
        $this->sections = $sections;
    }

    /**
     * @param string $uid
     */
    public function addSection(string $uid)
    {
        if ($uid && $uid !== '00000000-0000-0000-0000-000000000000') {
            array_push($this->sections, $uid);
        }
    }

    /**
     * @return ClientCategoryDto[]
     */
    public function getClientCategories(): array
    {
        return $this->clientCategories;
    }

    /**
     * @param array
     */
    public function setClientCategories(array $clientCategories): void
    {
        foreach ($clientCategories as $uid) {
            $this->addClientCategory($uid);
        }
    }

    /**
     * @param string
     */
    public function addClientCategory(string $uid)
    {
        if ($uid && $uid !== '00000000-0000-0000-0000-000000000000') {
            array_push($this->clientCategories, $uid);
        }
    }

    /**
     * @return string
     */
    public function getArticle(): string
    {
        return $this->article;
    }

    /**
     * @param string $article
     */
    public function setArticle(string $article): void
    {
        $this->article = $article;
    }

    /**
     * @return string
     */
    public function getPrintableTitle(): string
    {
        return $this->printableTitle;
    }

    /**
     * @param string $printableTitle
     */
    public function setPrintableTitle(string $printableTitle): void
    {
        $this->printableTitle = $printableTitle;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * @return array
     */
    public function getRelatedProducts(): array
    {
        return $this->relatedProducts;
    }

    /**
     * @param array
     */
    public function setRelatedProducts(array $relatedProducts): void
    {
        foreach ($relatedProducts as $uid) {
            $this->addRelatedProduct($uid);
        }
    }

    /**
     * @param string $uid
     */
    public function addRelatedProduct(string $uid)
    {
        if ($uid && $uid !== '00000000-0000-0000-0000-000000000000') {
            array_push($this->relatedProducts, $uid);
        }
    }

    /**
     * @return array
     */
    public function getUsages(): array
    {
        return $this->usages;
    }

    /**
     * @param array $usages
     */
    public function setUsages(array $usages): void
    {
        foreach ($usages as $uid) {
            $this->addUsage($uid);
        }
    }

    /**
     * @param string $uid
     */
    public function addUsage(string $uid)
    {
        if ($uid && $uid !== '00000000-0000-0000-0000-000000000000') {
            array_push($this->usages, $uid);
        }
    }

    /**
     * @return array
     */
    public function getVideos(): array
    {
        return $this->videos;
    }

    /**
     * @param array $videos
     */
    public function setVideos(array $videos): void
    {
        foreach ($videos as $video) {
            $this->addVideo($video);
        }
    }

    /**
     * @param string $url
     */
    public function addVideo(string $url)
    {
        if (preg_match('#youtube\.com(.*)embed\/([\w\d\-]+)#', $url)) {
            array_push($this->videos, $url);
        } elseif (preg_match('#youtube\.com(.*)v=([\w\d\-]+)#', $url, $matches)) {
            array_push($this->videos, 'https://www.youtube.com/embed/' . $matches[2]);
        }
    }

    /**
     * @return int
     */
    public function getActive(): int
    {
        return $this->active;
    }

    /**
     * @param int $active
     */
    public function setActive(int $active): void
    {
        $this->active = $active;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * @param string $createdAt
     */
    public function setCreatedAt(string $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    /**
     * @param string $updatedAt
     */
    public function setUpdatedAt(string $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return FileDto[]
     */
    public function getDocuments(): array
    {
        return $this->documents;
    }

    /**
     * @param FileDto[] $documents
     */
    public function setDocuments(array $documents): void
    {
        $this->documents = $documents;
    }

    /**
     * @param FileDto $dto
     */
    public function addDocument(FileDto $dto)
    {
        array_push($this->documents, $dto);
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title ?: html_entity_decode($this->printableTitle);
    }

    /**
     * @return ParamDto[]
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param array $params
     */
    public function setParams(array $params): void
    {
        $this->params = $params;
    }

    /**
     * @param ParamDto $dto
     */
    public function addParam(ParamDto $dto)
    {
        array_push($this->params, $dto);
    }

    /**
     * @return FileDto|null
     */
    public function getImages(): ?array
    {
        return $this->images;
    }

    /**
     * @param null|FileDto[] $images
     */
    public function setImages(?array $images): void
    {
        if ($images) {
            $this->images = [];
            foreach ($images as $image) {
                $this->addImage($image);
            }
        }
    }

    /**
     * @param FileDto $image
     */
    public function addImage(FileDto $image)
    {
        array_push($this->images, $image);
    }

}
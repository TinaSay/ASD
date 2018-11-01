<?php

namespace app\modules\product\dto;

/**
 * Class ProductSetDto
 *
 * @package app\modules\product\dto
 */
class ProductSetDto extends BaseDto
{
    /**
     * @var null|FileDto[]
     */
    protected $images = [];

    /**
     * @var array
     */
    protected $videos = [];

    /**
     * @var FileDto[]
     */
    protected $documents = [];

    /**
     * @var string
     */
    protected $description = '';

    /**
     * @var string
     */
    protected $category = '';

    /**
     * @var ProductSetItemDto[]
     */
    protected $productItems = [];

    /**
     * @var int
     */
    protected $position = 0;

    /**
     * @var string
     */
    protected $article = '';

    /**
     * @return ProductSetItemDto[]
     */
    public function getProductItems(): array
    {
        return $this->productItems;
    }

    /**
     * @param array $productItems
     */
    public function setProductItems(array $productItems): void
    {
        $this->productItems = $productItems;
    }

    /**
     * @param ProductSetItemDto $dto
     */
    public function addProductItem(ProductSetItemDto $dto)
    {
        if ($dto->getProductUid() &&
            $dto->getProductUid() !== '00000000-0000-0000-0000-000000000000') {
            array_push($this->productItems, $dto);
        }
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
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @param string $category
     */
    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * @param int $position
     */
    public function setPosition(int $position): void
    {
        $this->position = $position;
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
}
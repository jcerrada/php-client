<?php

/*
 * This file is part of the Search PHP Library.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author PuntMig Technologies
 */

declare(strict_types=1);

namespace Puntmig\Search\Result;

use Puntmig\Search\Model\Brand;
use Puntmig\Search\Model\Category;
use Puntmig\Search\Model\HttpTransportable;
use Puntmig\Search\Model\Manufacturer;
use Puntmig\Search\Model\Product;
use Puntmig\Search\Model\Tag;

/**
 * Class Result.
 */
class Result implements HttpTransportable
{
    /**
     * @var array
     *
     * Abbreviations
     */
    private $abbreviations = [
        'p' => 'products',
        'c' => 'categories',
        'm' => 'manufacturers',
        'b' => 'brands',
        't' => 'tags',
    ];

    /**
     * @var Product[]
     *
     * Products
     */
    private $products = [];

    /**
     * @var Category[]
     *
     * Categories
     */
    private $categories = [];

    /**
     * @var Manufacturer[]
     *
     * Manufacturers
     */
    private $manufacturers = [];

    /**
     * @var Brand[]
     *
     * Brands
     */
    private $brands = [];

    /**
     * @var Tag[]
     *
     * Tags
     */
    private $tags = [];

    /**
     * @var array
     *
     * Results
     */
    private $results = [];

    /**
     * @var Aggregations
     *
     * Aggregations
     */
    private $aggregations;

    /**
     * Total elements.
     *
     * @var int
     */
    private $totalElements;

    /**
     * Total products.
     *
     * @var int
     */
    private $totalProducts;

    /**
     * Total hits.
     *
     * @var int
     */
    private $totalHits;

    /**
     * Min price.
     *
     * @var int
     */
    private $minPrice;

    /**
     * Max price.
     *
     * @var int
     */
    private $maxPrice;

    /**
     * Result constructor.
     *
     * @param int $totalElements
     * @param int $totalProducts
     * @param int $totalHits
     * @param int $minPrice
     * @param int $maxPrice
     */
    public function __construct(
        int $totalElements,
        int $totalProducts,
        int $totalHits,
        int $minPrice,
        int $maxPrice
    ) {
        $this->totalElements = $totalElements;
        $this->totalProducts = $totalProducts;
        $this->totalHits = $totalHits;
        $this->minPrice = $minPrice;
        $this->maxPrice = $maxPrice;
    }

    /**
     * Add product.
     *
     * @param Product $product
     */
    public function addProduct(Product $product)
    {
        $productUUID = $product
            ->getProductReference()
            ->composeUUID();

        $this->products[$productUUID] = $product;
        $this->results[] = ['p', $productUUID];
    }

    /**
     * Get products.
     *
     * @return Product[]
     */
    public function getProducts(): array
    {
        return array_values($this->products);
    }

    /**
     * Add category.
     *
     * @param Category $category
     */
    public function addCategory(Category $category)
    {
        $categoryUUID = $category
            ->getCategoryReference()
            ->composeUUID();

        $this->categories[$categoryUUID] = $category;
        $this->results[] = ['c', $categoryUUID];
    }

    /**
     * Get categories.
     *
     * @return Category[]
     */
    public function getCategories(): array
    {
        return array_values($this->categories);
    }

    /**
     * Add manufacturer.
     *
     * @param Manufacturer $manufacturer
     */
    public function addManufacturer(Manufacturer $manufacturer)
    {
        $manufacturerUUID = $manufacturer
            ->getManufacturerReference()
            ->composeUUID();

        $this->manufacturers[$manufacturerUUID] = $manufacturer;
        $this->results[] = ['m', $manufacturerUUID];
    }

    /**
     * Get manufacturers.
     *
     * @return Manufacturer[]
     */
    public function getManufacturers(): array
    {
        return array_values($this->manufacturers);
    }

    /**
     * Add brand.
     *
     * @param Brand $brand
     */
    public function addBrand(Brand $brand)
    {
        $brandUUID = $brand
            ->getBrandReference()
            ->composeUUID();

        $this->brands[$brandUUID] = $brand;
        $this->results[] = ['b', $brandUUID];
    }

    /**
     * Get brands.
     *
     * @return Brand[]
     */
    public function getBrands(): array
    {
        return array_values($this->brands);
    }

    /**
     * Add tag.
     *
     * @param Tag $tag
     */
    public function addTag(Tag $tag)
    {
        $tagUUID = $tag
            ->getTagReference()
            ->composeUUID();

        $this->tags[$tagUUID] = $tag;
        $this->results[] = ['t', $tagUUID];
    }

    /**
     * Get tags.
     *
     * @return Tag[]
     */
    public function getTags(): array
    {
        return array_values($this->tags);
    }

    /**
     * Get results.
     *
     * @return array
     */
    public function getResults() : array
    {
        return array_values(
            array_map(function (array $result) {
                $container = $this->abbreviations[$result[0]];

                return $this->$container[$result[1]];
            }, $this->results)
        );
    }

    /**
     * Set aggregations.
     *
     * @param Aggregations $aggregations
     */
    public function setAggregations(Aggregations $aggregations)
    {
        $this->aggregations = $aggregations;
    }

    /**
     * Get aggregations.
     *
     * @return Aggregations
     */
    public function getAggregations(): Aggregations
    {
        return $this->aggregations;
    }

    /**
     * Get aggregation.
     *
     * @param string $name
     *
     * @return null|Aggregation
     */
    public function getAggregation(string $name) : ? Aggregation
    {
        return $this
            ->getAggregations()
            ->getAggregation($name);
    }

    /**
     * Total elements.
     *
     * @return int
     */
    public function getTotalElements() : int
    {
        return $this->totalElements;
    }

    /**
     * Total products.
     *
     * @return int
     */
    public function getTotalProducts(): int
    {
        return $this->totalProducts;
    }

    /**
     * Get total hits.
     *
     * @return int
     */
    public function getTotalHits() : int
    {
        return $this->totalHits;
    }

    /**
     * Get min price.
     *
     * @return int
     */
    public function getMinPrice(): int
    {
        return $this->minPrice;
    }

    /**
     * Get max price.
     *
     * @return int
     */
    public function getMaxPrice(): int
    {
        return $this->maxPrice;
    }

    /**
     * To array.
     *
     * @return array
     */
    public function toArray() : array
    {
        return [
            'total_elements' => $this->totalElements,
            'total_products' => $this->totalProducts,
            'total_hits' => $this->totalHits,
            'min_price' => $this->minPrice,
            'max_price' => $this->maxPrice,
            'products' => array_map(function (Product $product) {
                return $product->toArray();
            }, $this->products),
            'categories' => array_map(function (Category $category) {
                return $category->toArray();
            }, $this->categories),
            'brands' => array_map(function (Brand $brand) {
                return $brand->toArray();
            }, $this->brands),
            'manufacturers' => array_map(function (Manufacturer $manufacturer) {
                return $manufacturer->toArray();
            }, $this->manufacturers),
            'tags' => array_map(function (Tag $tag) {
                return $tag->toArray();
            }, $this->tags),
            'results' => $this->results,
            'aggregations' => $this->aggregations->toArray(),
        ];
    }

    /**
     * Create from array.
     *
     * @param array $array
     *
     * @return self
     */
    public static function createFromArray(array $array) : self
    {
        $result = new self(
            $array['total_elements'],
            $array['total_products'],
            $array['total_hits'],
            $array['min_price'],
            $array['max_price']
        );

        $result->products = array_map(function (array $product) {
            return Product::createFromArray($product);
        }, $array['products']);

        $result->categories = array_map(function (array $category) {
            return Category::createFromArray($category);
        }, $array['categories']);

        $result->manufacturers = array_map(function (array $manufacturer) {
            return Manufacturer::createFromArray($manufacturer);
        }, $array['manufacturers']);

        $result->brands = array_map(function (array $brand) {
            return Brand::createFromArray($brand);
        }, $array['brands']);

        $result->tags = array_map(function (array $tag) {
            return Tag::createFromArray($tag);
        }, $array['tags']);

        $result->results = $array['results'] ?? [];

        $result->aggregations = Aggregations::createFromArray($array['aggregations']);

        return $result;
    }
}

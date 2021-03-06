<?php

/*
 * This file is part of the Apisearch PHP Client.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 */

declare(strict_types=1);

namespace Apisearch\Http;

/**
 * Class Endpoints.
 */
class Endpoints
{
    /**
     * Get all endpoints.
     *
     * @return array
     */
    public static function all(): array
    {
        return [
            /*
             * Application endpoints
             */
            'v1-indices-get' => [
                'name' => 'Get all indices',
                'description' => 'Get all indices',
                'path' => '/v1/indices',
                'verb' => 'get',
            ],
            'v1-index-create' => [
                'name' => 'Index create',
                'description' => 'Reset your App index',
                'path' => '/v1/index',
                'verb' => 'put',
            ],
            'v1-index-delete' => [
                'name' => 'Index delete',
                'description' => 'Delete your App index',
                'path' => '/v1/index',
                'verb' => 'delete',
            ],
            'v1-index-reset' => [
                'name' => 'Index reset',
                'description' => 'Reset your App index',
                'path' => '/v1/index/reset',
                'verb' => 'post',
            ],
            'v1-index-check' => [
                'name' => 'Index check',
                'description' => 'Check your index',
                'path' => '/v1/index',
                'verb' => 'head',
            ],
            'v1-index-config' => [
                'name' => 'Index Config',
                'description' => 'Configure your index',
                'path' => '/v1/index',
                'verb' => 'post',
            ],
            'v1-token-add' => [
                'name' => 'Add token',
                'description' => 'Add token',
                'path' => '/v1/token',
                'verb' => 'post',
            ],
            'v1-token-delete' => [
                'name' => 'Delete token',
                'description' => 'Delete token',
                'path' => '/v1/token',
                'verb' => 'delete',
            ],
            'v1-tokens-get' => [
                'name' => 'Get all tokens',
                'description' => 'Get all tokens',
                'path' => '/v1/tokens',
                'verb' => 'get',
            ],
            'v1-tokens-delete' => [
                'name' => 'Delete all tokens',
                'description' => 'Delete all tokens',
                'path' => '/v1/tokens',
                'verb' => 'delete',
            ],

            /*
             * Query endpoints
             */
            'v1-query' => [
                'name' => 'Query',
                'description' => 'Make queries',
                'path' => '/v1',
                'verb' => 'get',
            ],
            'v1-items-index' => [
                'name' => 'Items index',
                'description' => 'Index your items',
                'path' => '/v1/items',
                'verb' => 'post',
            ],
            'v1-items-delete' => [
                'name' => 'Items delete',
                'description' => 'Delete your items',
                'path' => '/v1/items',
                'verb' => 'delete',
            ],
            'v1-items-update' => [
                'name' => 'Items update',
                'description' => 'Update your items',
                'path' => '/v1/items',
                'verb' => 'put',
            ],

            /*
             * User endpoints
             */
            'v1-interaction' => [
                'name' => 'Add interaction',
                'description' => 'Push a new interaction',
                'path' => '/v1/interaction',
                'verb' => 'get',
            ],
            'v1-interactions-delete' => [
                'name' => 'Delete Interactions',
                'description' => 'Delete all stored interactions',
                'path' => '/v1/interactions',
                'verb' => 'delete',
            ],
        ];
    }

    /**
     * Clean input with only valid elements.
     *
     * @param string[] $permissions
     *
     * @return string[]
     */
    public static function filter(array $permissions)
    {
        return array_intersect(
            $permissions,
            array_keys(self::all())
        );
    }

    /**
     * Read and Write endpoints.
     */
    public static function readWrite(): array
    {
        return array_keys(self::all());
    }

    /**
     * Index Write endpoints.
     */
    public static function indexWrite(): array
    {
        return [
            'v1-index-create',
            'v1-index-delete',
            'v1-items-index',
            'v1-items-delete',
            'v1-index-reset',
        ];
    }

    /**
     * Query endpoints.
     */
    public static function queryOnly(): array
    {
        return [
            'v1-query',
        ];
    }

    /**
     * Read endpoints.
     */
    public static function tokensOnly(): array
    {
        return [
            'v1-token-add',
            'v1-token-delete',
            'v1-tokens-get',
            'v1-tokens-delete-all',
        ];
    }

    /**
     * Interaction endpoints.
     */
    public static function interactionOnly(): array
    {
        return [
            'v1-interaction',
        ];
    }

    /**
     * To composed.
     *
     * @param string[] $endpoints
     *
     * @return string[]
     */
    public static function compose(array $endpoints)
    {
        $all = self::all();

        return array_values(array_filter(array_map(function (string $endpoint) use ($all) {
            return isset($all[$endpoint])
                ? strtolower($all[$endpoint]['verb'].'~~'.$all[$endpoint]['path'])
                : '';
        }, $endpoints)));
    }

    /**
     * From composed.
     *
     * @param string[] $endpoints
     *
     * @return string[]
     */
    public static function fromComposed(array $endpoints)
    {
        $all = self::all();
        $allInversed = [];

        array_walk($all, function (array $element, string $name) use (&$allInversed) {
            $composed = strtolower($element['verb'].'~~'.$element['path']);
            $allInversed[$composed] = $name;
        });

        return array_values(array_filter(array_map(function (string $endpoint) use ($allInversed) {
            return isset($allInversed[$endpoint])
                ? $allInversed[$endpoint]
                : '';
        }, $endpoints)));
    }
}

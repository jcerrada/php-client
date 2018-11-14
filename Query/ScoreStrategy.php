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

namespace Apisearch\Query;

use Apisearch\Model\HttpTransportable;

/**
 * Class ScoreStrategy.
 */
class ScoreStrategy implements HttpTransportable
{
    /**
     * @var string
     *
     * Default score strategy
     */
    const DEFAULT_TYPE = 'default';

    /**
     * @var float
     *
     * Default weight
     */
    const DEFAULT_WEIGHT = 1.0;

    /**
     * @var string
     *
     * Boosting by field value
     */
    const BOOSTING_FIELD_VALUE = 'field_value';

    /**
     * @var string
     *
     * Boosting by relevance field
     */
    const CUSTOM_FUNCTION = 'custom_function';

    /**
     * @var string
     *
     * Decay linear
     */
    const DECAY_LINEAR = 'linear';

    /**
     * @var string
     *
     * Decay exp
     */
    const DECAY_EXP = 'exp';

    /**
     * @var string
     *
     * Decay exp
     */
    const DECAY_GAUSS = 'gauss';

    /**
     * @var string
     *
     * Boosting by relevance field
     */
    const DECAY = 'decay';

    /**
     * @var string
     *
     * Modifier none
     */
    const MODIFIER_NONE = 'none';

    /**
     * @var string
     *
     * Modifier sqrt
     */
    const MODIFIER_SQRT = 'sqrt';

    /**
     * @var string
     *
     * Modifier log
     */
    const MODIFIER_LOG = 'log';

    /**
     * @var string
     *
     * Modifier log natural
     */
    const MODIFIER_LN = 'ln';

    /**
     * @var string
     *
     * Modifier square
     */
    const MODIFIER_SQUARE = 'square';

    /**
     * @var float
     *
     * Default missing
     */
    const DEFAULT_MISSING = 1.0;

    /**
     * @var float
     *
     * Default factor
     */
    const DEFAULT_FACTOR = 1.0;

    /**
     * @var string
     *
     * Scoring type
     */
    private $type = self::DEFAULT_TYPE;

    /**
     * Filter.
     *
     * @var Filter
     */
    private $filter;

    /**
     * @var float
     *
     * Weight
     */
    private $weight;

    /**
     * Configuration.
     *
     * @var array
     */
    private $configuration = [];

    /**
     * Get type.
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Get configuration value.
     *
     * @param string $element
     *
     * @return null|mixed
     */
    public function getConfigurationValue(string $element)
    {
        return $this->configuration[$element] ?? null;
    }

    /**
     * Get weight.
     *
     * @return float
     */
    public function getWeight(): float
    {
        return $this->weight;
    }

    /**
     * Get filter.
     *
     * @return Filter|null
     */
    public function getFilter(): ? Filter
    {
        return $this->filter;
    }

    /**
     * Create empty.
     *
     * @return self
     */
    public static function createDefault(): self
    {
        return new self();
    }

    /**
     * Create default field scoring.
     *
     * @param string $field
     * @param float  $factor
     * @param float  $missing
     * @param string $modifier
     * @param float  $weight
     * @param Filter $filter
     *
     * @return self
     */
    public static function createFieldBoosting(
        string $field,
        float $factor = self::DEFAULT_FACTOR,
        float $missing = self::DEFAULT_MISSING,
        string $modifier = self::MODIFIER_NONE,
        float $weight = self::DEFAULT_WEIGHT,
        Filter $filter = null
    ): self {
        $scoreStrategy = self::createDefault();
        $scoreStrategy->type = self::BOOSTING_FIELD_VALUE;
        $scoreStrategy->configuration['field'] = $field;
        $scoreStrategy->configuration['factor'] = $factor;
        $scoreStrategy->configuration['missing'] = $missing;
        $scoreStrategy->configuration['modifier'] = $modifier;
        $scoreStrategy->weight = $weight;
        $scoreStrategy->filter = $filter;

        return $scoreStrategy;
    }

    /**
     * Create custom function scoring.
     *
     * @param string $function
     * @param float  $weight
     * @param Filter $filter
     *
     * @return self
     */
    public static function createCustomFunction(
        string $function,
        float $weight = self::DEFAULT_WEIGHT,
        Filter $filter = null
    ): self {
        $scoreStrategy = self::createDefault();
        $scoreStrategy->type = self::CUSTOM_FUNCTION;
        $scoreStrategy->configuration['function'] = $function;
        $scoreStrategy->weight = $weight;
        $scoreStrategy->filter = $filter;

        return $scoreStrategy;
    }

    /**
     * Create custom function scoring.
     *
     * @param string $type
     * @param string $field
     * @param string $origin
     * @param string $scale
     * @param string $offset
     * @param float  $decay
     * @param float  $weight
     * @param Filter $filter
     *
     * @return self
     */
    public static function createDecayFunction(
        string $type,
        string $field,
        string $origin,
        string $scale,
        string $offset,
        float $decay,
        float $weight = self::DEFAULT_WEIGHT,
        Filter $filter = null
    ): self {
        $scoreStrategy = self::createDefault();
        $scoreStrategy->type = self::DECAY;
        $scoreStrategy->configuration['type'] = $type;
        $scoreStrategy->configuration['field'] = $field;
        $scoreStrategy->configuration['origin'] = $origin;
        $scoreStrategy->configuration['scale'] = $scale;
        $scoreStrategy->configuration['offset'] = $offset;
        $scoreStrategy->configuration['decay'] = $decay;
        $scoreStrategy->weight = $weight;
        $scoreStrategy->filter = $filter;

        return $scoreStrategy;
    }

    /**
     * To array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'configuration' => $this->configuration,
            'weight' => $this->weight,
            'filter' => $this->filter,
        ];
    }

    /**
     * Create from array.
     *
     * @param array $array
     *
     * @return self
     */
    public static function createFromArray(array $array)
    {
        $scoreStrategy = new self();
        $scoreStrategy->type = $array['type'] ?: self::DEFAULT_TYPE;
        $scoreStrategy->configuration = $array['configuration'] ?? [];
        $scoreStrategy->weight = $array['weight'] ?? self::DEFAULT_WEIGHT;
        $scoreStrategy->filter = $array['filter'] ?? null;

        return $scoreStrategy;
    }
}

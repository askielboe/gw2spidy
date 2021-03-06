<?php

namespace GW2Spidy\DB\om;

use \Criteria;
use \Exception;
use \ModelCriteria;
use \ModelJoin;
use \PDO;
use \Propel;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use GW2Spidy\DB\GemToGoldRate;
use GW2Spidy\DB\GemToGoldRatePeer;
use GW2Spidy\DB\GemToGoldRateQuery;

/**
 * Base class that represents a query for the 'gem_to_gold_rate' table.
 *
 * 
 *
 * @method     GemToGoldRateQuery orderByRateDatetime($order = Criteria::ASC) Order by the rate_datetime column
 * @method     GemToGoldRateQuery orderByRate($order = Criteria::ASC) Order by the rate column
 * @method     GemToGoldRateQuery orderByVolume($order = Criteria::ASC) Order by the volume column
 *
 * @method     GemToGoldRateQuery groupByRateDatetime() Group by the rate_datetime column
 * @method     GemToGoldRateQuery groupByRate() Group by the rate column
 * @method     GemToGoldRateQuery groupByVolume() Group by the volume column
 *
 * @method     GemToGoldRateQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     GemToGoldRateQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     GemToGoldRateQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     GemToGoldRate findOne(PropelPDO $con = null) Return the first GemToGoldRate matching the query
 * @method     GemToGoldRate findOneOrCreate(PropelPDO $con = null) Return the first GemToGoldRate matching the query, or a new GemToGoldRate object populated from the query conditions when no match is found
 *
 * @method     GemToGoldRate findOneByRateDatetime(string $rate_datetime) Return the first GemToGoldRate filtered by the rate_datetime column
 * @method     GemToGoldRate findOneByRate(int $rate) Return the first GemToGoldRate filtered by the rate column
 * @method     GemToGoldRate findOneByVolume(string $volume) Return the first GemToGoldRate filtered by the volume column
 *
 * @method     array findByRateDatetime(string $rate_datetime) Return GemToGoldRate objects filtered by the rate_datetime column
 * @method     array findByRate(int $rate) Return GemToGoldRate objects filtered by the rate column
 * @method     array findByVolume(string $volume) Return GemToGoldRate objects filtered by the volume column
 *
 * @package    propel.generator.gw2spidy.om
 */
abstract class BaseGemToGoldRateQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of BaseGemToGoldRateQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'gw2spidy', $modelName = 'GW2Spidy\\DB\\GemToGoldRate', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new GemToGoldRateQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     GemToGoldRateQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return GemToGoldRateQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof GemToGoldRateQuery) {
            return $criteria;
        }
        $query = new GemToGoldRateQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query 
     * @param     PropelPDO $con an optional connection object
     *
     * @return   GemToGoldRate|GemToGoldRate[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = GemToGoldRatePeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(GemToGoldRatePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return   GemToGoldRate A model object, or null if the key is not found
     * @throws   PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `RATE_DATETIME`, `RATE`, `VOLUME` FROM `gem_to_gold_rate` WHERE `RATE_DATETIME` = :p0';
        try {
            $stmt = $con->prepare($sql);
			$stmt->bindValue(':p0', $key, PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new GemToGoldRate();
            $obj->hydrate($row);
            GemToGoldRatePeer::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return GemToGoldRate|GemToGoldRate[]|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return PropelObjectCollection|GemToGoldRate[]|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($stmt);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return GemToGoldRateQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(GemToGoldRatePeer::RATE_DATETIME, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return GemToGoldRateQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(GemToGoldRatePeer::RATE_DATETIME, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the rate_datetime column
     *
     * Example usage:
     * <code>
     * $query->filterByRateDatetime('2011-03-14'); // WHERE rate_datetime = '2011-03-14'
     * $query->filterByRateDatetime('now'); // WHERE rate_datetime = '2011-03-14'
     * $query->filterByRateDatetime(array('max' => 'yesterday')); // WHERE rate_datetime > '2011-03-13'
     * </code>
     *
     * @param     mixed $rateDatetime The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return GemToGoldRateQuery The current query, for fluid interface
     */
    public function filterByRateDatetime($rateDatetime = null, $comparison = null)
    {
        if (is_array($rateDatetime)) {
            $useMinMax = false;
            if (isset($rateDatetime['min'])) {
                $this->addUsingAlias(GemToGoldRatePeer::RATE_DATETIME, $rateDatetime['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($rateDatetime['max'])) {
                $this->addUsingAlias(GemToGoldRatePeer::RATE_DATETIME, $rateDatetime['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GemToGoldRatePeer::RATE_DATETIME, $rateDatetime, $comparison);
    }

    /**
     * Filter the query on the rate column
     *
     * Example usage:
     * <code>
     * $query->filterByRate(1234); // WHERE rate = 1234
     * $query->filterByRate(array(12, 34)); // WHERE rate IN (12, 34)
     * $query->filterByRate(array('min' => 12)); // WHERE rate > 12
     * </code>
     *
     * @param     mixed $rate The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return GemToGoldRateQuery The current query, for fluid interface
     */
    public function filterByRate($rate = null, $comparison = null)
    {
        if (is_array($rate)) {
            $useMinMax = false;
            if (isset($rate['min'])) {
                $this->addUsingAlias(GemToGoldRatePeer::RATE, $rate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($rate['max'])) {
                $this->addUsingAlias(GemToGoldRatePeer::RATE, $rate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GemToGoldRatePeer::RATE, $rate, $comparison);
    }

    /**
     * Filter the query on the volume column
     *
     * Example usage:
     * <code>
     * $query->filterByVolume(1234); // WHERE volume = 1234
     * $query->filterByVolume(array(12, 34)); // WHERE volume IN (12, 34)
     * $query->filterByVolume(array('min' => 12)); // WHERE volume > 12
     * </code>
     *
     * @param     mixed $volume The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return GemToGoldRateQuery The current query, for fluid interface
     */
    public function filterByVolume($volume = null, $comparison = null)
    {
        if (is_array($volume)) {
            $useMinMax = false;
            if (isset($volume['min'])) {
                $this->addUsingAlias(GemToGoldRatePeer::VOLUME, $volume['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($volume['max'])) {
                $this->addUsingAlias(GemToGoldRatePeer::VOLUME, $volume['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GemToGoldRatePeer::VOLUME, $volume, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   GemToGoldRate $gemToGoldRate Object to remove from the list of results
     *
     * @return GemToGoldRateQuery The current query, for fluid interface
     */
    public function prune($gemToGoldRate = null)
    {
        if ($gemToGoldRate) {
            $this->addUsingAlias(GemToGoldRatePeer::RATE_DATETIME, $gemToGoldRate->getRateDatetime(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

} // BaseGemToGoldRateQuery
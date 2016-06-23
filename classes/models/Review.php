<?php

/**
 * Created by PhpStorm.
 * User: adamkisala
 * Date: 25/05/2016
 * Time: 18:07
 */

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/db_handlers/Model.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/db_handlers/Database.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/constants/Constants.php');

/**
 * Class Review
 */
class Review
{

    private $reviewer_id = null;

    /**
     * @return null
     */
    public function getReviewerId()
    {
        return $this->reviewer_id;
    }

    /**
     * @param null $reviewer_id
     */
    public function setReviewerId($reviewer_id)
    {
        $this->reviewer_id = $reviewer_id;
    }
    /**
     * @var null
     */
    private $review_id = null;
    /**
     * @var null
     */
    private $user_id = null;
    /**
     * @var null
     */
    private $exchange_id = null;
    /**
     * @var string
     */
    private $description = '';

    /**
     * @return null
     */
    public function getReviewId()
    {
        return $this->review_id;
    }

    /**
     * @param null $review_id
     */
    public function setReviewId($review_id)
    {
        $this->review_id = $review_id;
    }

    /**
     * @return null
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param null $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return null
     */
    public function getExchangeId()
    {
        return $this->exchange_id;
    }

    /**
     * @param null $exchange_id
     */
    public function setExchangeId($exchange_id)
    {
        $this->exchange_id = $exchange_id;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return null
     */
    public function getEvaluation()
    {
        return $this->evaluation;
    }

    /**
     * @param null $evaluation
     */
    public function setEvaluation($evaluation)
    {
        $this->evaluation = $evaluation;
    }

    /**
     * @return null
     */
    public function getDateTime()
    {
        return $this->date_time;
    }

    /**
     * @param null $date_time
     */
    public function setDateTime($date_time)
    {
        $this->date_time = $date_time;
    }

    /**
     * @var null
     */
    private $evaluation = null;
    /**
     * @var null
     */
    private $date_time = null;

    /**
     * Review constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param $review_id
     * @return Review
     */
    public static function __constructWithIdFromDB($review_id)
    {
        $instance = new self();
        $db_connection = Database::getInstance();
        $db_model = new Model($db_connection);
        $review = $db_model->readFirst(REVIEWS_TABLE, 'review_id', $review_id);
        if ($review){
            $instance->review_id = $review['review_id'];
            $instance->exchange_id = $review['exchange_id'];
            $instance->user_id = $review['user_id'];
            $instance->description = $review['description'];
            $instance->evaluation = $review['evaluation'];
            $instance->date_time = $review['date_time'];
            $instance->reviewer_id = $review['reviewer_id'];
        }
        return $instance;
    }
}
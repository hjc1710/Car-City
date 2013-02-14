<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hayden
 * Date: 2/13/13
 * Time: 10:23 PM
 * To change this template use File | Settings | File Templates.
 */

/**
 * A class that represents the very basic concept of a Vehicle.
 *
 * Is an abstract class defining generic functions that all vehicles share:
 * - Start
 * - Stop
 * - Accelerate
 * - Decelerate
 *
 * Also implements a few persistent elements, namely a password and salt that,
 *  in theory, would replace the physical key.
 *
 * @package     Vehicles
 * @subpackage  VehicleGeneric
 * @author      Hayden Chudy <hjc1710@gmail.com>
 */
abstract class Vehicle
{
    //helps us make the salt and has other useful methods
    use Text_Helper;
    /** @var int Contains total count of vehicles */
    public static $vehicle_count = 0;

    /** @var int The individual number of this vehicle */
    public $vehicle_number = 0;

    /** @var int Holds vehicle's current speed */
    public $current_speed = 0;

    /** @var int Holds vehicle's top speed */
    public $top_speed;

    /** @var int The weight of the vehicle */
    public $weight;

    /** @var int How many people the vehicle can hold. */
    public $capacity;

    /** @var bool Is the engine on? alternatively, is the car started? */
    protected $engine_on = FALSE;

    /** @var string A salt we will append to our vehicle's password for safety */
    protected $vehicle_salt;

    /** @var string The hashed password that starts the vehicle, we will see if the
     *              key matches this after it has been hashed. */
    protected $hashed_password;

    /** @var bool Are the headlights on? */
    protected $headlights_on = FALSE;

    /** @var bool Are the windshield wipers on? */
    protected $wipers_on = FALSE;

    /**
     * Construct the object, increasing vehicle count, making a future salt, and
     *  setting the vehicle number.
     *
     * @param int $weight       The weight of the vehicle, in lbs.
     * @param int $cap     The max number of people the vehicle can hold
     */
    function __construct($weight, $cap) {
        //make a salt for this vehicle's password
        $this->vehicle_salt = $this->create_salt();

        //set vehicle number and then increment vehicle count
        $this->vehicle_number = Vehicle::$vehicle_count++;

        $this->weight = $weight;
        $this->capacity = $cap;

        echo "Created new Vehicle\n";
    }

    protected  function name() {
        $class = get_class($this);

        $count_name = strtolower($class) . '_number';
        return $class . "#" . $this->$count_name;
    }


    /**
     * Set and store a password in a vehicle for later use. This serves as a key for
     *  a vehicle;
     *
     * @param string $string    The string that we are going to hash and store. This becomes the vehicle's
     *                          password/key and is used to "activate" it
     */
    function set_password($string) {
        $this->hashed_password = hash('sha256', $string . $this->vehicle_salt);
    }

    /**
     * Turn the vehicle's windshield wipers on and say so
     */
    public function wipers_on() {
        $this->wipers_on = TRUE;
        echo get_class($this) . " turning windshield wipers on!\n";
    }

    /**
     * Turn the vehicle's windshield wipers off and say so
     */
    public function wipers_off() {
        $this->wipers_on = FALSE;
        $class = get_class($this);

        $count_name = strtolower($class) . '_number';
        echo '<br>' . $count_name . '<br>';
        echo $class . "#" . $this->$count_name . " turning windshield wipers off!\n";
    }

    public function check_wipers() {
        //echo $this->wipers_on ?
    }

    /**
     * Turn the vehicle's headlights off
     */
    function headlights_off() {
        $this->headlights_on = FALSE;
        echo get_class($this) . " turning headlights off!\n";
    }

    /**
     * Turn the vehicle's headlights on
     */
    function headlights_on() {
        $this->headlights_on = TRUE;
        echo get_class($this) . " turning headlights on!\n";
    }

    /**
     * Increase the vehicle's speed by providing an acceleration rate (m/s^2) and
     *  a duration (s).
     *
     * @param float $rate          Acceleration rate, in m^2
     * @param float $duration      Acceleration time, in s
     */
    abstract public function accelerate($rate, $duration);

    /**
     * Decrease the vehicle's speed by providing an acceleration rate (m/s^2) and
     *  a duration (s).
     *
     * @param float $rate          Acceleration rate, in m^2
     * @param float $duration      Acceleration time, in s
     */
    abstract public function decelerate($rate, $duration);

    /**
     * Start the vehicle.
     *
     * @param string $key       A password the user provides to start their vehicle (high-tech, huh?)
     */
    abstract public function start($key);

    /**
     * Stop the vehicle.
     */
    abstract public function stop();
}
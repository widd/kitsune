<?php

namespace Base;

use \PenguinsQuery as ChildPenguinsQuery;
use \Exception;
use \PDO;
use Map\PenguinsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;

/**
 * Base class that represents a row from the 'penguins' table.
 *
 * 
 *
* @package    propel.generator..Base
*/
abstract class Penguins implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\PenguinsTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     * 
     * @var        int
     */
    protected $id;

    /**
     * The value for the username field.
     * 
     * @var        string
     */
    protected $username;

    /**
     * The value for the nickname field.
     * 
     * @var        string
     */
    protected $nickname;

    /**
     * The value for the password field.
     * 
     * @var        string
     */
    protected $password;

    /**
     * The value for the loginkey field.
     * 
     * @var        string
     */
    protected $loginkey;

    /**
     * The value for the confirmationhash field.
     * 
     * @var        string
     */
    protected $confirmationhash;

    /**
     * The value for the swid field.
     * 
     * @var        string
     */
    protected $swid;

    /**
     * The value for the avatar field.
     * 
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $avatar;

    /**
     * The value for the avatarattributes field.
     * 
     * Note: this column has a database default value of: '{"spriteScale":100,"spriteSpeed":100,"ignoresBlockLayer":false,"invisible":false,"floating":false}'
     * @var        string
     */
    protected $avatarattributes;

    /**
     * The value for the email field.
     * 
     * @var        string
     */
    protected $email;

    /**
     * The value for the registrationdate field.
     * 
     * @var        int
     */
    protected $registrationdate;

    /**
     * The value for the moderator field.
     * 
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $moderator;

    /**
     * The value for the inventory field.
     * 
     * @var        string
     */
    protected $inventory;

    /**
     * The value for the careinventory field.
     * 
     * @var        string
     */
    protected $careinventory;

    /**
     * The value for the coins field.
     * 
     * Note: this column has a database default value of: 200000
     * @var        int
     */
    protected $coins;

    /**
     * The value for the igloo field.
     * 
     * @var        int
     */
    protected $igloo;

    /**
     * The value for the igloos field.
     * 
     * @var        string
     */
    protected $igloos;

    /**
     * The value for the floors field.
     * 
     * @var        string
     */
    protected $floors;

    /**
     * The value for the locations field.
     * 
     * @var        string
     */
    protected $locations;

    /**
     * The value for the furniture field.
     * 
     * @var        string
     */
    protected $furniture;

    /**
     * The value for the color field.
     * 
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $color;

    /**
     * The value for the head field.
     * 
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $head;

    /**
     * The value for the face field.
     * 
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $face;

    /**
     * The value for the neck field.
     * 
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $neck;

    /**
     * The value for the body field.
     * 
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $body;

    /**
     * The value for the hand field.
     * 
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $hand;

    /**
     * The value for the feet field.
     * 
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $feet;

    /**
     * The value for the photo field.
     * 
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $photo;

    /**
     * The value for the flag field.
     * 
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $flag;

    /**
     * The value for the walking field.
     * 
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $walking;

    /**
     * The value for the banned field.
     * 
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $banned;

    /**
     * The value for the stamps field.
     * 
     * @var        string
     */
    protected $stamps;

    /**
     * The value for the stampbook field.
     * 
     * Note: this column has a database default value of: '1%1%1%1'
     * @var        string
     */
    protected $stampbook;

    /**
     * The value for the epf field.
     * 
     * Note: this column has a database default value of: '0,0,0'
     * @var        string
     */
    protected $epf;

    /**
     * The value for the pufflequest field.
     * 
     * Note: this column has a database default value of: '0,1,|0;0;1403959119;'
     * @var        string
     */
    protected $pufflequest;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->avatar = 0;
        $this->avatarattributes = '{"spriteScale":100,"spriteSpeed":100,"ignoresBlockLayer":false,"invisible":false,"floating":false}';
        $this->moderator = false;
        $this->coins = 200000;
        $this->color = 1;
        $this->head = 0;
        $this->face = 0;
        $this->neck = 0;
        $this->body = 0;
        $this->hand = 0;
        $this->feet = 0;
        $this->photo = 0;
        $this->flag = 0;
        $this->walking = 0;
        $this->banned = '0';
        $this->stampbook = '1%1%1%1';
        $this->epf = '0,0,0';
        $this->pufflequest = '0,1,|0;0;1403959119;';
    }

    /**
     * Initializes internal state of Base\Penguins object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Penguins</code> instance.  If
     * <code>obj</code> is an instance of <code>Penguins</code>, delegates to
     * <code>equals(Penguins)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|Penguins The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));
        
        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }
        
        return $propertyNames;
    }

    /**
     * Get the [id] column value.
     * 
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [username] column value.
     * 
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Get the [nickname] column value.
     * 
     * @return string
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * Get the [password] column value.
     * 
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get the [loginkey] column value.
     * 
     * @return string
     */
    public function getLoginkey()
    {
        return $this->loginkey;
    }

    /**
     * Get the [confirmationhash] column value.
     * 
     * @return string
     */
    public function getConfirmationhash()
    {
        return $this->confirmationhash;
    }

    /**
     * Get the [swid] column value.
     * 
     * @return string
     */
    public function getSwid()
    {
        return $this->swid;
    }

    /**
     * Get the [avatar] column value.
     * 
     * @return int
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Get the [avatarattributes] column value.
     * 
     * @return string
     */
    public function getAvatarattributes()
    {
        return $this->avatarattributes;
    }

    /**
     * Get the [email] column value.
     * 
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the [registrationdate] column value.
     * 
     * @return int
     */
    public function getRegistrationdate()
    {
        return $this->registrationdate;
    }

    /**
     * Get the [moderator] column value.
     * 
     * @return boolean
     */
    public function getModerator()
    {
        return $this->moderator;
    }

    /**
     * Get the [moderator] column value.
     * 
     * @return boolean
     */
    public function isModerator()
    {
        return $this->getModerator();
    }

    /**
     * Get the [inventory] column value.
     * 
     * @return string
     */
    public function getInventory()
    {
        return $this->inventory;
    }

    /**
     * Get the [careinventory] column value.
     * 
     * @return string
     */
    public function getCareinventory()
    {
        return $this->careinventory;
    }

    /**
     * Get the [coins] column value.
     * 
     * @return int
     */
    public function getCoins()
    {
        return $this->coins;
    }

    /**
     * Get the [igloo] column value.
     * 
     * @return int
     */
    public function getIgloo()
    {
        return $this->igloo;
    }

    /**
     * Get the [igloos] column value.
     * 
     * @return string
     */
    public function getIgloos()
    {
        return $this->igloos;
    }

    /**
     * Get the [floors] column value.
     * 
     * @return string
     */
    public function getFloors()
    {
        return $this->floors;
    }

    /**
     * Get the [locations] column value.
     * 
     * @return string
     */
    public function getLocations()
    {
        return $this->locations;
    }

    /**
     * Get the [furniture] column value.
     * 
     * @return string
     */
    public function getFurniture()
    {
        return $this->furniture;
    }

    /**
     * Get the [color] column value.
     * 
     * @return int
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Get the [head] column value.
     * 
     * @return int
     */
    public function getHead()
    {
        return $this->head;
    }

    /**
     * Get the [face] column value.
     * 
     * @return int
     */
    public function getFace()
    {
        return $this->face;
    }

    /**
     * Get the [neck] column value.
     * 
     * @return int
     */
    public function getNeck()
    {
        return $this->neck;
    }

    /**
     * Get the [body] column value.
     * 
     * @return int
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Get the [hand] column value.
     * 
     * @return int
     */
    public function getHand()
    {
        return $this->hand;
    }

    /**
     * Get the [feet] column value.
     * 
     * @return int
     */
    public function getFeet()
    {
        return $this->feet;
    }

    /**
     * Get the [photo] column value.
     * 
     * @return int
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Get the [flag] column value.
     * 
     * @return int
     */
    public function getFlag()
    {
        return $this->flag;
    }

    /**
     * Get the [walking] column value.
     * 
     * @return int
     */
    public function getWalking()
    {
        return $this->walking;
    }

    /**
     * Get the [banned] column value.
     * 
     * @return string
     */
    public function getBanned()
    {
        return $this->banned;
    }

    /**
     * Get the [stamps] column value.
     * 
     * @return string
     */
    public function getStamps()
    {
        return $this->stamps;
    }

    /**
     * Get the [stampbook] column value.
     * 
     * @return string
     */
    public function getStampbook()
    {
        return $this->stampbook;
    }

    /**
     * Get the [epf] column value.
     * 
     * @return string
     */
    public function getEpf()
    {
        return $this->epf;
    }

    /**
     * Get the [pufflequest] column value.
     * 
     * @return string
     */
    public function getPufflequest()
    {
        return $this->pufflequest;
    }

    /**
     * Set the value of [id] column.
     * 
     * @param int $v new value
     * @return $this|\Penguins The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[PenguinsTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [username] column.
     * 
     * @param string $v new value
     * @return $this|\Penguins The current object (for fluent API support)
     */
    public function setUsername($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->username !== $v) {
            $this->username = $v;
            $this->modifiedColumns[PenguinsTableMap::COL_USERNAME] = true;
        }

        return $this;
    } // setUsername()

    /**
     * Set the value of [nickname] column.
     * 
     * @param string $v new value
     * @return $this|\Penguins The current object (for fluent API support)
     */
    public function setNickname($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->nickname !== $v) {
            $this->nickname = $v;
            $this->modifiedColumns[PenguinsTableMap::COL_NICKNAME] = true;
        }

        return $this;
    } // setNickname()

    /**
     * Set the value of [password] column.
     * 
     * @param string $v new value
     * @return $this|\Penguins The current object (for fluent API support)
     */
    public function setPassword($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->password !== $v) {
            $this->password = $v;
            $this->modifiedColumns[PenguinsTableMap::COL_PASSWORD] = true;
        }

        return $this;
    } // setPassword()

    /**
     * Set the value of [loginkey] column.
     * 
     * @param string $v new value
     * @return $this|\Penguins The current object (for fluent API support)
     */
    public function setLoginkey($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->loginkey !== $v) {
            $this->loginkey = $v;
            $this->modifiedColumns[PenguinsTableMap::COL_LOGINKEY] = true;
        }

        return $this;
    } // setLoginkey()

    /**
     * Set the value of [confirmationhash] column.
     * 
     * @param string $v new value
     * @return $this|\Penguins The current object (for fluent API support)
     */
    public function setConfirmationhash($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->confirmationhash !== $v) {
            $this->confirmationhash = $v;
            $this->modifiedColumns[PenguinsTableMap::COL_CONFIRMATIONHASH] = true;
        }

        return $this;
    } // setConfirmationhash()

    /**
     * Set the value of [swid] column.
     * 
     * @param string $v new value
     * @return $this|\Penguins The current object (for fluent API support)
     */
    public function setSwid($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->swid !== $v) {
            $this->swid = $v;
            $this->modifiedColumns[PenguinsTableMap::COL_SWID] = true;
        }

        return $this;
    } // setSwid()

    /**
     * Set the value of [avatar] column.
     * 
     * @param int $v new value
     * @return $this|\Penguins The current object (for fluent API support)
     */
    public function setAvatar($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->avatar !== $v) {
            $this->avatar = $v;
            $this->modifiedColumns[PenguinsTableMap::COL_AVATAR] = true;
        }

        return $this;
    } // setAvatar()

    /**
     * Set the value of [avatarattributes] column.
     * 
     * @param string $v new value
     * @return $this|\Penguins The current object (for fluent API support)
     */
    public function setAvatarattributes($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->avatarattributes !== $v) {
            $this->avatarattributes = $v;
            $this->modifiedColumns[PenguinsTableMap::COL_AVATARATTRIBUTES] = true;
        }

        return $this;
    } // setAvatarattributes()

    /**
     * Set the value of [email] column.
     * 
     * @param string $v new value
     * @return $this|\Penguins The current object (for fluent API support)
     */
    public function setEmail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->email !== $v) {
            $this->email = $v;
            $this->modifiedColumns[PenguinsTableMap::COL_EMAIL] = true;
        }

        return $this;
    } // setEmail()

    /**
     * Set the value of [registrationdate] column.
     * 
     * @param int $v new value
     * @return $this|\Penguins The current object (for fluent API support)
     */
    public function setRegistrationdate($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->registrationdate !== $v) {
            $this->registrationdate = $v;
            $this->modifiedColumns[PenguinsTableMap::COL_REGISTRATIONDATE] = true;
        }

        return $this;
    } // setRegistrationdate()

    /**
     * Sets the value of the [moderator] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * 
     * @param  boolean|integer|string $v The new value
     * @return $this|\Penguins The current object (for fluent API support)
     */
    public function setModerator($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->moderator !== $v) {
            $this->moderator = $v;
            $this->modifiedColumns[PenguinsTableMap::COL_MODERATOR] = true;
        }

        return $this;
    } // setModerator()

    /**
     * Set the value of [inventory] column.
     * 
     * @param string $v new value
     * @return $this|\Penguins The current object (for fluent API support)
     */
    public function setInventory($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->inventory !== $v) {
            $this->inventory = $v;
            $this->modifiedColumns[PenguinsTableMap::COL_INVENTORY] = true;
        }

        return $this;
    } // setInventory()

    /**
     * Set the value of [careinventory] column.
     * 
     * @param string $v new value
     * @return $this|\Penguins The current object (for fluent API support)
     */
    public function setCareinventory($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->careinventory !== $v) {
            $this->careinventory = $v;
            $this->modifiedColumns[PenguinsTableMap::COL_CAREINVENTORY] = true;
        }

        return $this;
    } // setCareinventory()

    /**
     * Set the value of [coins] column.
     * 
     * @param int $v new value
     * @return $this|\Penguins The current object (for fluent API support)
     */
    public function setCoins($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->coins !== $v) {
            $this->coins = $v;
            $this->modifiedColumns[PenguinsTableMap::COL_COINS] = true;
        }

        return $this;
    } // setCoins()

    /**
     * Set the value of [igloo] column.
     * 
     * @param int $v new value
     * @return $this|\Penguins The current object (for fluent API support)
     */
    public function setIgloo($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->igloo !== $v) {
            $this->igloo = $v;
            $this->modifiedColumns[PenguinsTableMap::COL_IGLOO] = true;
        }

        return $this;
    } // setIgloo()

    /**
     * Set the value of [igloos] column.
     * 
     * @param string $v new value
     * @return $this|\Penguins The current object (for fluent API support)
     */
    public function setIgloos($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->igloos !== $v) {
            $this->igloos = $v;
            $this->modifiedColumns[PenguinsTableMap::COL_IGLOOS] = true;
        }

        return $this;
    } // setIgloos()

    /**
     * Set the value of [floors] column.
     * 
     * @param string $v new value
     * @return $this|\Penguins The current object (for fluent API support)
     */
    public function setFloors($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->floors !== $v) {
            $this->floors = $v;
            $this->modifiedColumns[PenguinsTableMap::COL_FLOORS] = true;
        }

        return $this;
    } // setFloors()

    /**
     * Set the value of [locations] column.
     * 
     * @param string $v new value
     * @return $this|\Penguins The current object (for fluent API support)
     */
    public function setLocations($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->locations !== $v) {
            $this->locations = $v;
            $this->modifiedColumns[PenguinsTableMap::COL_LOCATIONS] = true;
        }

        return $this;
    } // setLocations()

    /**
     * Set the value of [furniture] column.
     * 
     * @param string $v new value
     * @return $this|\Penguins The current object (for fluent API support)
     */
    public function setFurniture($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->furniture !== $v) {
            $this->furniture = $v;
            $this->modifiedColumns[PenguinsTableMap::COL_FURNITURE] = true;
        }

        return $this;
    } // setFurniture()

    /**
     * Set the value of [color] column.
     * 
     * @param int $v new value
     * @return $this|\Penguins The current object (for fluent API support)
     */
    public function setColor($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->color !== $v) {
            $this->color = $v;
            $this->modifiedColumns[PenguinsTableMap::COL_COLOR] = true;
        }

        return $this;
    } // setColor()

    /**
     * Set the value of [head] column.
     * 
     * @param int $v new value
     * @return $this|\Penguins The current object (for fluent API support)
     */
    public function setHead($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->head !== $v) {
            $this->head = $v;
            $this->modifiedColumns[PenguinsTableMap::COL_HEAD] = true;
        }

        return $this;
    } // setHead()

    /**
     * Set the value of [face] column.
     * 
     * @param int $v new value
     * @return $this|\Penguins The current object (for fluent API support)
     */
    public function setFace($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->face !== $v) {
            $this->face = $v;
            $this->modifiedColumns[PenguinsTableMap::COL_FACE] = true;
        }

        return $this;
    } // setFace()

    /**
     * Set the value of [neck] column.
     * 
     * @param int $v new value
     * @return $this|\Penguins The current object (for fluent API support)
     */
    public function setNeck($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->neck !== $v) {
            $this->neck = $v;
            $this->modifiedColumns[PenguinsTableMap::COL_NECK] = true;
        }

        return $this;
    } // setNeck()

    /**
     * Set the value of [body] column.
     * 
     * @param int $v new value
     * @return $this|\Penguins The current object (for fluent API support)
     */
    public function setBody($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->body !== $v) {
            $this->body = $v;
            $this->modifiedColumns[PenguinsTableMap::COL_BODY] = true;
        }

        return $this;
    } // setBody()

    /**
     * Set the value of [hand] column.
     * 
     * @param int $v new value
     * @return $this|\Penguins The current object (for fluent API support)
     */
    public function setHand($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->hand !== $v) {
            $this->hand = $v;
            $this->modifiedColumns[PenguinsTableMap::COL_HAND] = true;
        }

        return $this;
    } // setHand()

    /**
     * Set the value of [feet] column.
     * 
     * @param int $v new value
     * @return $this|\Penguins The current object (for fluent API support)
     */
    public function setFeet($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->feet !== $v) {
            $this->feet = $v;
            $this->modifiedColumns[PenguinsTableMap::COL_FEET] = true;
        }

        return $this;
    } // setFeet()

    /**
     * Set the value of [photo] column.
     * 
     * @param int $v new value
     * @return $this|\Penguins The current object (for fluent API support)
     */
    public function setPhoto($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->photo !== $v) {
            $this->photo = $v;
            $this->modifiedColumns[PenguinsTableMap::COL_PHOTO] = true;
        }

        return $this;
    } // setPhoto()

    /**
     * Set the value of [flag] column.
     * 
     * @param int $v new value
     * @return $this|\Penguins The current object (for fluent API support)
     */
    public function setFlag($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->flag !== $v) {
            $this->flag = $v;
            $this->modifiedColumns[PenguinsTableMap::COL_FLAG] = true;
        }

        return $this;
    } // setFlag()

    /**
     * Set the value of [walking] column.
     * 
     * @param int $v new value
     * @return $this|\Penguins The current object (for fluent API support)
     */
    public function setWalking($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->walking !== $v) {
            $this->walking = $v;
            $this->modifiedColumns[PenguinsTableMap::COL_WALKING] = true;
        }

        return $this;
    } // setWalking()

    /**
     * Set the value of [banned] column.
     * 
     * @param string $v new value
     * @return $this|\Penguins The current object (for fluent API support)
     */
    public function setBanned($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->banned !== $v) {
            $this->banned = $v;
            $this->modifiedColumns[PenguinsTableMap::COL_BANNED] = true;
        }

        return $this;
    } // setBanned()

    /**
     * Set the value of [stamps] column.
     * 
     * @param string $v new value
     * @return $this|\Penguins The current object (for fluent API support)
     */
    public function setStamps($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->stamps !== $v) {
            $this->stamps = $v;
            $this->modifiedColumns[PenguinsTableMap::COL_STAMPS] = true;
        }

        return $this;
    } // setStamps()

    /**
     * Set the value of [stampbook] column.
     * 
     * @param string $v new value
     * @return $this|\Penguins The current object (for fluent API support)
     */
    public function setStampbook($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->stampbook !== $v) {
            $this->stampbook = $v;
            $this->modifiedColumns[PenguinsTableMap::COL_STAMPBOOK] = true;
        }

        return $this;
    } // setStampbook()

    /**
     * Set the value of [epf] column.
     * 
     * @param string $v new value
     * @return $this|\Penguins The current object (for fluent API support)
     */
    public function setEpf($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->epf !== $v) {
            $this->epf = $v;
            $this->modifiedColumns[PenguinsTableMap::COL_EPF] = true;
        }

        return $this;
    } // setEpf()

    /**
     * Set the value of [pufflequest] column.
     * 
     * @param string $v new value
     * @return $this|\Penguins The current object (for fluent API support)
     */
    public function setPufflequest($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->pufflequest !== $v) {
            $this->pufflequest = $v;
            $this->modifiedColumns[PenguinsTableMap::COL_PUFFLEQUEST] = true;
        }

        return $this;
    } // setPufflequest()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
            if ($this->avatar !== 0) {
                return false;
            }

            if ($this->avatarattributes !== '{"spriteScale":100,"spriteSpeed":100,"ignoresBlockLayer":false,"invisible":false,"floating":false}') {
                return false;
            }

            if ($this->moderator !== false) {
                return false;
            }

            if ($this->coins !== 200000) {
                return false;
            }

            if ($this->color !== 1) {
                return false;
            }

            if ($this->head !== 0) {
                return false;
            }

            if ($this->face !== 0) {
                return false;
            }

            if ($this->neck !== 0) {
                return false;
            }

            if ($this->body !== 0) {
                return false;
            }

            if ($this->hand !== 0) {
                return false;
            }

            if ($this->feet !== 0) {
                return false;
            }

            if ($this->photo !== 0) {
                return false;
            }

            if ($this->flag !== 0) {
                return false;
            }

            if ($this->walking !== 0) {
                return false;
            }

            if ($this->banned !== '0') {
                return false;
            }

            if ($this->stampbook !== '1%1%1%1') {
                return false;
            }

            if ($this->epf !== '0,0,0') {
                return false;
            }

            if ($this->pufflequest !== '0,1,|0;0;1403959119;') {
                return false;
            }

        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : PenguinsTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : PenguinsTableMap::translateFieldName('Username', TableMap::TYPE_PHPNAME, $indexType)];
            $this->username = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : PenguinsTableMap::translateFieldName('Nickname', TableMap::TYPE_PHPNAME, $indexType)];
            $this->nickname = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : PenguinsTableMap::translateFieldName('Password', TableMap::TYPE_PHPNAME, $indexType)];
            $this->password = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : PenguinsTableMap::translateFieldName('Loginkey', TableMap::TYPE_PHPNAME, $indexType)];
            $this->loginkey = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : PenguinsTableMap::translateFieldName('Confirmationhash', TableMap::TYPE_PHPNAME, $indexType)];
            $this->confirmationhash = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : PenguinsTableMap::translateFieldName('Swid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->swid = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : PenguinsTableMap::translateFieldName('Avatar', TableMap::TYPE_PHPNAME, $indexType)];
            $this->avatar = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : PenguinsTableMap::translateFieldName('Avatarattributes', TableMap::TYPE_PHPNAME, $indexType)];
            $this->avatarattributes = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : PenguinsTableMap::translateFieldName('Email', TableMap::TYPE_PHPNAME, $indexType)];
            $this->email = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : PenguinsTableMap::translateFieldName('Registrationdate', TableMap::TYPE_PHPNAME, $indexType)];
            $this->registrationdate = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : PenguinsTableMap::translateFieldName('Moderator', TableMap::TYPE_PHPNAME, $indexType)];
            $this->moderator = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : PenguinsTableMap::translateFieldName('Inventory', TableMap::TYPE_PHPNAME, $indexType)];
            $this->inventory = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : PenguinsTableMap::translateFieldName('Careinventory', TableMap::TYPE_PHPNAME, $indexType)];
            $this->careinventory = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : PenguinsTableMap::translateFieldName('Coins', TableMap::TYPE_PHPNAME, $indexType)];
            $this->coins = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 15 + $startcol : PenguinsTableMap::translateFieldName('Igloo', TableMap::TYPE_PHPNAME, $indexType)];
            $this->igloo = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 16 + $startcol : PenguinsTableMap::translateFieldName('Igloos', TableMap::TYPE_PHPNAME, $indexType)];
            $this->igloos = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 17 + $startcol : PenguinsTableMap::translateFieldName('Floors', TableMap::TYPE_PHPNAME, $indexType)];
            $this->floors = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 18 + $startcol : PenguinsTableMap::translateFieldName('Locations', TableMap::TYPE_PHPNAME, $indexType)];
            $this->locations = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 19 + $startcol : PenguinsTableMap::translateFieldName('Furniture', TableMap::TYPE_PHPNAME, $indexType)];
            $this->furniture = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 20 + $startcol : PenguinsTableMap::translateFieldName('Color', TableMap::TYPE_PHPNAME, $indexType)];
            $this->color = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 21 + $startcol : PenguinsTableMap::translateFieldName('Head', TableMap::TYPE_PHPNAME, $indexType)];
            $this->head = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 22 + $startcol : PenguinsTableMap::translateFieldName('Face', TableMap::TYPE_PHPNAME, $indexType)];
            $this->face = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 23 + $startcol : PenguinsTableMap::translateFieldName('Neck', TableMap::TYPE_PHPNAME, $indexType)];
            $this->neck = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 24 + $startcol : PenguinsTableMap::translateFieldName('Body', TableMap::TYPE_PHPNAME, $indexType)];
            $this->body = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 25 + $startcol : PenguinsTableMap::translateFieldName('Hand', TableMap::TYPE_PHPNAME, $indexType)];
            $this->hand = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 26 + $startcol : PenguinsTableMap::translateFieldName('Feet', TableMap::TYPE_PHPNAME, $indexType)];
            $this->feet = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 27 + $startcol : PenguinsTableMap::translateFieldName('Photo', TableMap::TYPE_PHPNAME, $indexType)];
            $this->photo = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 28 + $startcol : PenguinsTableMap::translateFieldName('Flag', TableMap::TYPE_PHPNAME, $indexType)];
            $this->flag = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 29 + $startcol : PenguinsTableMap::translateFieldName('Walking', TableMap::TYPE_PHPNAME, $indexType)];
            $this->walking = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 30 + $startcol : PenguinsTableMap::translateFieldName('Banned', TableMap::TYPE_PHPNAME, $indexType)];
            $this->banned = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 31 + $startcol : PenguinsTableMap::translateFieldName('Stamps', TableMap::TYPE_PHPNAME, $indexType)];
            $this->stamps = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 32 + $startcol : PenguinsTableMap::translateFieldName('Stampbook', TableMap::TYPE_PHPNAME, $indexType)];
            $this->stampbook = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 33 + $startcol : PenguinsTableMap::translateFieldName('Epf', TableMap::TYPE_PHPNAME, $indexType)];
            $this->epf = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 34 + $startcol : PenguinsTableMap::translateFieldName('Pufflequest', TableMap::TYPE_PHPNAME, $indexType)];
            $this->pufflequest = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 35; // 35 = PenguinsTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Penguins'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PenguinsTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildPenguinsQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Penguins::setDeleted()
     * @see Penguins::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PenguinsTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildPenguinsQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PenguinsTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                PenguinsTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[PenguinsTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . PenguinsTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(PenguinsTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'ID';
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_USERNAME)) {
            $modifiedColumns[':p' . $index++]  = 'Username';
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_NICKNAME)) {
            $modifiedColumns[':p' . $index++]  = 'Nickname';
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_PASSWORD)) {
            $modifiedColumns[':p' . $index++]  = 'Password';
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_LOGINKEY)) {
            $modifiedColumns[':p' . $index++]  = 'LoginKey';
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_CONFIRMATIONHASH)) {
            $modifiedColumns[':p' . $index++]  = 'ConfirmationHash';
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_SWID)) {
            $modifiedColumns[':p' . $index++]  = 'SWID';
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_AVATAR)) {
            $modifiedColumns[':p' . $index++]  = 'Avatar';
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_AVATARATTRIBUTES)) {
            $modifiedColumns[':p' . $index++]  = 'AvatarAttributes';
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_EMAIL)) {
            $modifiedColumns[':p' . $index++]  = 'Email';
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_REGISTRATIONDATE)) {
            $modifiedColumns[':p' . $index++]  = 'RegistrationDate';
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_MODERATOR)) {
            $modifiedColumns[':p' . $index++]  = 'Moderator';
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_INVENTORY)) {
            $modifiedColumns[':p' . $index++]  = 'Inventory';
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_CAREINVENTORY)) {
            $modifiedColumns[':p' . $index++]  = 'CareInventory';
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_COINS)) {
            $modifiedColumns[':p' . $index++]  = 'Coins';
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_IGLOO)) {
            $modifiedColumns[':p' . $index++]  = 'Igloo';
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_IGLOOS)) {
            $modifiedColumns[':p' . $index++]  = 'Igloos';
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_FLOORS)) {
            $modifiedColumns[':p' . $index++]  = 'Floors';
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_LOCATIONS)) {
            $modifiedColumns[':p' . $index++]  = 'Locations';
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_FURNITURE)) {
            $modifiedColumns[':p' . $index++]  = 'Furniture';
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_COLOR)) {
            $modifiedColumns[':p' . $index++]  = 'Color';
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_HEAD)) {
            $modifiedColumns[':p' . $index++]  = 'Head';
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_FACE)) {
            $modifiedColumns[':p' . $index++]  = 'Face';
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_NECK)) {
            $modifiedColumns[':p' . $index++]  = 'Neck';
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_BODY)) {
            $modifiedColumns[':p' . $index++]  = 'Body';
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_HAND)) {
            $modifiedColumns[':p' . $index++]  = 'Hand';
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_FEET)) {
            $modifiedColumns[':p' . $index++]  = 'Feet';
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_PHOTO)) {
            $modifiedColumns[':p' . $index++]  = 'Photo';
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_FLAG)) {
            $modifiedColumns[':p' . $index++]  = 'Flag';
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_WALKING)) {
            $modifiedColumns[':p' . $index++]  = 'Walking';
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_BANNED)) {
            $modifiedColumns[':p' . $index++]  = 'Banned';
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_STAMPS)) {
            $modifiedColumns[':p' . $index++]  = 'Stamps';
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_STAMPBOOK)) {
            $modifiedColumns[':p' . $index++]  = 'StampBook';
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_EPF)) {
            $modifiedColumns[':p' . $index++]  = 'EPF';
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_PUFFLEQUEST)) {
            $modifiedColumns[':p' . $index++]  = 'PuffleQuest';
        }

        $sql = sprintf(
            'INSERT INTO penguins (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'ID':                        
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'Username':                        
                        $stmt->bindValue($identifier, $this->username, PDO::PARAM_STR);
                        break;
                    case 'Nickname':                        
                        $stmt->bindValue($identifier, $this->nickname, PDO::PARAM_STR);
                        break;
                    case 'Password':                        
                        $stmt->bindValue($identifier, $this->password, PDO::PARAM_STR);
                        break;
                    case 'LoginKey':                        
                        $stmt->bindValue($identifier, $this->loginkey, PDO::PARAM_STR);
                        break;
                    case 'ConfirmationHash':                        
                        $stmt->bindValue($identifier, $this->confirmationhash, PDO::PARAM_STR);
                        break;
                    case 'SWID':                        
                        $stmt->bindValue($identifier, $this->swid, PDO::PARAM_STR);
                        break;
                    case 'Avatar':                        
                        $stmt->bindValue($identifier, $this->avatar, PDO::PARAM_INT);
                        break;
                    case 'AvatarAttributes':                        
                        $stmt->bindValue($identifier, $this->avatarattributes, PDO::PARAM_STR);
                        break;
                    case 'Email':                        
                        $stmt->bindValue($identifier, $this->email, PDO::PARAM_STR);
                        break;
                    case 'RegistrationDate':                        
                        $stmt->bindValue($identifier, $this->registrationdate, PDO::PARAM_INT);
                        break;
                    case 'Moderator':
                        $stmt->bindValue($identifier, (int) $this->moderator, PDO::PARAM_INT);
                        break;
                    case 'Inventory':                        
                        $stmt->bindValue($identifier, $this->inventory, PDO::PARAM_STR);
                        break;
                    case 'CareInventory':                        
                        $stmt->bindValue($identifier, $this->careinventory, PDO::PARAM_STR);
                        break;
                    case 'Coins':                        
                        $stmt->bindValue($identifier, $this->coins, PDO::PARAM_INT);
                        break;
                    case 'Igloo':                        
                        $stmt->bindValue($identifier, $this->igloo, PDO::PARAM_INT);
                        break;
                    case 'Igloos':                        
                        $stmt->bindValue($identifier, $this->igloos, PDO::PARAM_STR);
                        break;
                    case 'Floors':                        
                        $stmt->bindValue($identifier, $this->floors, PDO::PARAM_STR);
                        break;
                    case 'Locations':                        
                        $stmt->bindValue($identifier, $this->locations, PDO::PARAM_STR);
                        break;
                    case 'Furniture':                        
                        $stmt->bindValue($identifier, $this->furniture, PDO::PARAM_STR);
                        break;
                    case 'Color':                        
                        $stmt->bindValue($identifier, $this->color, PDO::PARAM_INT);
                        break;
                    case 'Head':                        
                        $stmt->bindValue($identifier, $this->head, PDO::PARAM_INT);
                        break;
                    case 'Face':                        
                        $stmt->bindValue($identifier, $this->face, PDO::PARAM_INT);
                        break;
                    case 'Neck':                        
                        $stmt->bindValue($identifier, $this->neck, PDO::PARAM_INT);
                        break;
                    case 'Body':                        
                        $stmt->bindValue($identifier, $this->body, PDO::PARAM_INT);
                        break;
                    case 'Hand':                        
                        $stmt->bindValue($identifier, $this->hand, PDO::PARAM_INT);
                        break;
                    case 'Feet':                        
                        $stmt->bindValue($identifier, $this->feet, PDO::PARAM_INT);
                        break;
                    case 'Photo':                        
                        $stmt->bindValue($identifier, $this->photo, PDO::PARAM_INT);
                        break;
                    case 'Flag':                        
                        $stmt->bindValue($identifier, $this->flag, PDO::PARAM_INT);
                        break;
                    case 'Walking':                        
                        $stmt->bindValue($identifier, $this->walking, PDO::PARAM_INT);
                        break;
                    case 'Banned':                        
                        $stmt->bindValue($identifier, $this->banned, PDO::PARAM_STR);
                        break;
                    case 'Stamps':                        
                        $stmt->bindValue($identifier, $this->stamps, PDO::PARAM_STR);
                        break;
                    case 'StampBook':                        
                        $stmt->bindValue($identifier, $this->stampbook, PDO::PARAM_STR);
                        break;
                    case 'EPF':                        
                        $stmt->bindValue($identifier, $this->epf, PDO::PARAM_STR);
                        break;
                    case 'PuffleQuest':                        
                        $stmt->bindValue($identifier, $this->pufflequest, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = PenguinsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getUsername();
                break;
            case 2:
                return $this->getNickname();
                break;
            case 3:
                return $this->getPassword();
                break;
            case 4:
                return $this->getLoginkey();
                break;
            case 5:
                return $this->getConfirmationhash();
                break;
            case 6:
                return $this->getSwid();
                break;
            case 7:
                return $this->getAvatar();
                break;
            case 8:
                return $this->getAvatarattributes();
                break;
            case 9:
                return $this->getEmail();
                break;
            case 10:
                return $this->getRegistrationdate();
                break;
            case 11:
                return $this->getModerator();
                break;
            case 12:
                return $this->getInventory();
                break;
            case 13:
                return $this->getCareinventory();
                break;
            case 14:
                return $this->getCoins();
                break;
            case 15:
                return $this->getIgloo();
                break;
            case 16:
                return $this->getIgloos();
                break;
            case 17:
                return $this->getFloors();
                break;
            case 18:
                return $this->getLocations();
                break;
            case 19:
                return $this->getFurniture();
                break;
            case 20:
                return $this->getColor();
                break;
            case 21:
                return $this->getHead();
                break;
            case 22:
                return $this->getFace();
                break;
            case 23:
                return $this->getNeck();
                break;
            case 24:
                return $this->getBody();
                break;
            case 25:
                return $this->getHand();
                break;
            case 26:
                return $this->getFeet();
                break;
            case 27:
                return $this->getPhoto();
                break;
            case 28:
                return $this->getFlag();
                break;
            case 29:
                return $this->getWalking();
                break;
            case 30:
                return $this->getBanned();
                break;
            case 31:
                return $this->getStamps();
                break;
            case 32:
                return $this->getStampbook();
                break;
            case 33:
                return $this->getEpf();
                break;
            case 34:
                return $this->getPufflequest();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array())
    {

        if (isset($alreadyDumpedObjects['Penguins'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Penguins'][$this->hashCode()] = true;
        $keys = PenguinsTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getUsername(),
            $keys[2] => $this->getNickname(),
            $keys[3] => $this->getPassword(),
            $keys[4] => $this->getLoginkey(),
            $keys[5] => $this->getConfirmationhash(),
            $keys[6] => $this->getSwid(),
            $keys[7] => $this->getAvatar(),
            $keys[8] => $this->getAvatarattributes(),
            $keys[9] => $this->getEmail(),
            $keys[10] => $this->getRegistrationdate(),
            $keys[11] => $this->getModerator(),
            $keys[12] => $this->getInventory(),
            $keys[13] => $this->getCareinventory(),
            $keys[14] => $this->getCoins(),
            $keys[15] => $this->getIgloo(),
            $keys[16] => $this->getIgloos(),
            $keys[17] => $this->getFloors(),
            $keys[18] => $this->getLocations(),
            $keys[19] => $this->getFurniture(),
            $keys[20] => $this->getColor(),
            $keys[21] => $this->getHead(),
            $keys[22] => $this->getFace(),
            $keys[23] => $this->getNeck(),
            $keys[24] => $this->getBody(),
            $keys[25] => $this->getHand(),
            $keys[26] => $this->getFeet(),
            $keys[27] => $this->getPhoto(),
            $keys[28] => $this->getFlag(),
            $keys[29] => $this->getWalking(),
            $keys[30] => $this->getBanned(),
            $keys[31] => $this->getStamps(),
            $keys[32] => $this->getStampbook(),
            $keys[33] => $this->getEpf(),
            $keys[34] => $this->getPufflequest(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }
        

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\Penguins
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = PenguinsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Penguins
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setUsername($value);
                break;
            case 2:
                $this->setNickname($value);
                break;
            case 3:
                $this->setPassword($value);
                break;
            case 4:
                $this->setLoginkey($value);
                break;
            case 5:
                $this->setConfirmationhash($value);
                break;
            case 6:
                $this->setSwid($value);
                break;
            case 7:
                $this->setAvatar($value);
                break;
            case 8:
                $this->setAvatarattributes($value);
                break;
            case 9:
                $this->setEmail($value);
                break;
            case 10:
                $this->setRegistrationdate($value);
                break;
            case 11:
                $this->setModerator($value);
                break;
            case 12:
                $this->setInventory($value);
                break;
            case 13:
                $this->setCareinventory($value);
                break;
            case 14:
                $this->setCoins($value);
                break;
            case 15:
                $this->setIgloo($value);
                break;
            case 16:
                $this->setIgloos($value);
                break;
            case 17:
                $this->setFloors($value);
                break;
            case 18:
                $this->setLocations($value);
                break;
            case 19:
                $this->setFurniture($value);
                break;
            case 20:
                $this->setColor($value);
                break;
            case 21:
                $this->setHead($value);
                break;
            case 22:
                $this->setFace($value);
                break;
            case 23:
                $this->setNeck($value);
                break;
            case 24:
                $this->setBody($value);
                break;
            case 25:
                $this->setHand($value);
                break;
            case 26:
                $this->setFeet($value);
                break;
            case 27:
                $this->setPhoto($value);
                break;
            case 28:
                $this->setFlag($value);
                break;
            case 29:
                $this->setWalking($value);
                break;
            case 30:
                $this->setBanned($value);
                break;
            case 31:
                $this->setStamps($value);
                break;
            case 32:
                $this->setStampbook($value);
                break;
            case 33:
                $this->setEpf($value);
                break;
            case 34:
                $this->setPufflequest($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = PenguinsTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setUsername($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setNickname($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setPassword($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setLoginkey($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setConfirmationhash($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setSwid($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setAvatar($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setAvatarattributes($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setEmail($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setRegistrationdate($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setModerator($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setInventory($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setCareinventory($arr[$keys[13]]);
        }
        if (array_key_exists($keys[14], $arr)) {
            $this->setCoins($arr[$keys[14]]);
        }
        if (array_key_exists($keys[15], $arr)) {
            $this->setIgloo($arr[$keys[15]]);
        }
        if (array_key_exists($keys[16], $arr)) {
            $this->setIgloos($arr[$keys[16]]);
        }
        if (array_key_exists($keys[17], $arr)) {
            $this->setFloors($arr[$keys[17]]);
        }
        if (array_key_exists($keys[18], $arr)) {
            $this->setLocations($arr[$keys[18]]);
        }
        if (array_key_exists($keys[19], $arr)) {
            $this->setFurniture($arr[$keys[19]]);
        }
        if (array_key_exists($keys[20], $arr)) {
            $this->setColor($arr[$keys[20]]);
        }
        if (array_key_exists($keys[21], $arr)) {
            $this->setHead($arr[$keys[21]]);
        }
        if (array_key_exists($keys[22], $arr)) {
            $this->setFace($arr[$keys[22]]);
        }
        if (array_key_exists($keys[23], $arr)) {
            $this->setNeck($arr[$keys[23]]);
        }
        if (array_key_exists($keys[24], $arr)) {
            $this->setBody($arr[$keys[24]]);
        }
        if (array_key_exists($keys[25], $arr)) {
            $this->setHand($arr[$keys[25]]);
        }
        if (array_key_exists($keys[26], $arr)) {
            $this->setFeet($arr[$keys[26]]);
        }
        if (array_key_exists($keys[27], $arr)) {
            $this->setPhoto($arr[$keys[27]]);
        }
        if (array_key_exists($keys[28], $arr)) {
            $this->setFlag($arr[$keys[28]]);
        }
        if (array_key_exists($keys[29], $arr)) {
            $this->setWalking($arr[$keys[29]]);
        }
        if (array_key_exists($keys[30], $arr)) {
            $this->setBanned($arr[$keys[30]]);
        }
        if (array_key_exists($keys[31], $arr)) {
            $this->setStamps($arr[$keys[31]]);
        }
        if (array_key_exists($keys[32], $arr)) {
            $this->setStampbook($arr[$keys[32]]);
        }
        if (array_key_exists($keys[33], $arr)) {
            $this->setEpf($arr[$keys[33]]);
        }
        if (array_key_exists($keys[34], $arr)) {
            $this->setPufflequest($arr[$keys[34]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\Penguins The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(PenguinsTableMap::DATABASE_NAME);

        if ($this->isColumnModified(PenguinsTableMap::COL_ID)) {
            $criteria->add(PenguinsTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_USERNAME)) {
            $criteria->add(PenguinsTableMap::COL_USERNAME, $this->username);
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_NICKNAME)) {
            $criteria->add(PenguinsTableMap::COL_NICKNAME, $this->nickname);
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_PASSWORD)) {
            $criteria->add(PenguinsTableMap::COL_PASSWORD, $this->password);
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_LOGINKEY)) {
            $criteria->add(PenguinsTableMap::COL_LOGINKEY, $this->loginkey);
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_CONFIRMATIONHASH)) {
            $criteria->add(PenguinsTableMap::COL_CONFIRMATIONHASH, $this->confirmationhash);
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_SWID)) {
            $criteria->add(PenguinsTableMap::COL_SWID, $this->swid);
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_AVATAR)) {
            $criteria->add(PenguinsTableMap::COL_AVATAR, $this->avatar);
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_AVATARATTRIBUTES)) {
            $criteria->add(PenguinsTableMap::COL_AVATARATTRIBUTES, $this->avatarattributes);
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_EMAIL)) {
            $criteria->add(PenguinsTableMap::COL_EMAIL, $this->email);
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_REGISTRATIONDATE)) {
            $criteria->add(PenguinsTableMap::COL_REGISTRATIONDATE, $this->registrationdate);
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_MODERATOR)) {
            $criteria->add(PenguinsTableMap::COL_MODERATOR, $this->moderator);
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_INVENTORY)) {
            $criteria->add(PenguinsTableMap::COL_INVENTORY, $this->inventory);
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_CAREINVENTORY)) {
            $criteria->add(PenguinsTableMap::COL_CAREINVENTORY, $this->careinventory);
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_COINS)) {
            $criteria->add(PenguinsTableMap::COL_COINS, $this->coins);
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_IGLOO)) {
            $criteria->add(PenguinsTableMap::COL_IGLOO, $this->igloo);
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_IGLOOS)) {
            $criteria->add(PenguinsTableMap::COL_IGLOOS, $this->igloos);
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_FLOORS)) {
            $criteria->add(PenguinsTableMap::COL_FLOORS, $this->floors);
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_LOCATIONS)) {
            $criteria->add(PenguinsTableMap::COL_LOCATIONS, $this->locations);
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_FURNITURE)) {
            $criteria->add(PenguinsTableMap::COL_FURNITURE, $this->furniture);
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_COLOR)) {
            $criteria->add(PenguinsTableMap::COL_COLOR, $this->color);
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_HEAD)) {
            $criteria->add(PenguinsTableMap::COL_HEAD, $this->head);
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_FACE)) {
            $criteria->add(PenguinsTableMap::COL_FACE, $this->face);
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_NECK)) {
            $criteria->add(PenguinsTableMap::COL_NECK, $this->neck);
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_BODY)) {
            $criteria->add(PenguinsTableMap::COL_BODY, $this->body);
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_HAND)) {
            $criteria->add(PenguinsTableMap::COL_HAND, $this->hand);
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_FEET)) {
            $criteria->add(PenguinsTableMap::COL_FEET, $this->feet);
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_PHOTO)) {
            $criteria->add(PenguinsTableMap::COL_PHOTO, $this->photo);
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_FLAG)) {
            $criteria->add(PenguinsTableMap::COL_FLAG, $this->flag);
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_WALKING)) {
            $criteria->add(PenguinsTableMap::COL_WALKING, $this->walking);
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_BANNED)) {
            $criteria->add(PenguinsTableMap::COL_BANNED, $this->banned);
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_STAMPS)) {
            $criteria->add(PenguinsTableMap::COL_STAMPS, $this->stamps);
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_STAMPBOOK)) {
            $criteria->add(PenguinsTableMap::COL_STAMPBOOK, $this->stampbook);
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_EPF)) {
            $criteria->add(PenguinsTableMap::COL_EPF, $this->epf);
        }
        if ($this->isColumnModified(PenguinsTableMap::COL_PUFFLEQUEST)) {
            $criteria->add(PenguinsTableMap::COL_PUFFLEQUEST, $this->pufflequest);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildPenguinsQuery::create();
        $criteria->add(PenguinsTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }
        
    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Penguins (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setUsername($this->getUsername());
        $copyObj->setNickname($this->getNickname());
        $copyObj->setPassword($this->getPassword());
        $copyObj->setLoginkey($this->getLoginkey());
        $copyObj->setConfirmationhash($this->getConfirmationhash());
        $copyObj->setSwid($this->getSwid());
        $copyObj->setAvatar($this->getAvatar());
        $copyObj->setAvatarattributes($this->getAvatarattributes());
        $copyObj->setEmail($this->getEmail());
        $copyObj->setRegistrationdate($this->getRegistrationdate());
        $copyObj->setModerator($this->getModerator());
        $copyObj->setInventory($this->getInventory());
        $copyObj->setCareinventory($this->getCareinventory());
        $copyObj->setCoins($this->getCoins());
        $copyObj->setIgloo($this->getIgloo());
        $copyObj->setIgloos($this->getIgloos());
        $copyObj->setFloors($this->getFloors());
        $copyObj->setLocations($this->getLocations());
        $copyObj->setFurniture($this->getFurniture());
        $copyObj->setColor($this->getColor());
        $copyObj->setHead($this->getHead());
        $copyObj->setFace($this->getFace());
        $copyObj->setNeck($this->getNeck());
        $copyObj->setBody($this->getBody());
        $copyObj->setHand($this->getHand());
        $copyObj->setFeet($this->getFeet());
        $copyObj->setPhoto($this->getPhoto());
        $copyObj->setFlag($this->getFlag());
        $copyObj->setWalking($this->getWalking());
        $copyObj->setBanned($this->getBanned());
        $copyObj->setStamps($this->getStamps());
        $copyObj->setStampbook($this->getStampbook());
        $copyObj->setEpf($this->getEpf());
        $copyObj->setPufflequest($this->getPufflequest());
        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \Penguins Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->username = null;
        $this->nickname = null;
        $this->password = null;
        $this->loginkey = null;
        $this->confirmationhash = null;
        $this->swid = null;
        $this->avatar = null;
        $this->avatarattributes = null;
        $this->email = null;
        $this->registrationdate = null;
        $this->moderator = null;
        $this->inventory = null;
        $this->careinventory = null;
        $this->coins = null;
        $this->igloo = null;
        $this->igloos = null;
        $this->floors = null;
        $this->locations = null;
        $this->furniture = null;
        $this->color = null;
        $this->head = null;
        $this->face = null;
        $this->neck = null;
        $this->body = null;
        $this->hand = null;
        $this->feet = null;
        $this->photo = null;
        $this->flag = null;
        $this->walking = null;
        $this->banned = null;
        $this->stamps = null;
        $this->stampbook = null;
        $this->epf = null;
        $this->pufflequest = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
        } // if ($deep)

    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(PenguinsTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}

<?php

/***********************************************************\
|* EasySQL Framework v1.0.3                                *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: column_type.php                               *|
|* ------------------------------------------------------- *|
|* Copyright (C) 2014                                      *|
|* ------------------------------------------------------- *|
|* This program is free software: you can redistribute     *|
|* it and/or modify it under the terms of the GNU Affero   *|
|* General Public License as published by the Free         *|
|* Software Foundation, either version 3 of the License,   *|
|* or any other, later, version of the License.            *|
|* ------------------------------------------------------- *|
|* This program is distributed in the hope that it will    *|
|* be useful, but WITHOUT ANY WARRANTY; without even the   *|
|* implied warranty of MERCHANTABILITY or FITNESS FOR A    *|
|* PARTICULAR PURPOSE.  See the GNU Affero General Public  *|
|* License for more details. You should have received a    *|
|* copy of the GNU Affero General Public License along     *|
|* with this program.                                      *|
|* ------------------------------------------------------- *|
|* If not, see <http://www.gnu.org/licenses/>.             *|
|* ------------------------------------------------------- *|
|* Removal of this copyright header is strictly prohibited *|
|* without written permission from the original author(s). *|
\***********************************************************/

// Security Check.

if (!defined("CONST_EASY_SQL")) exit("Action not allowed.");

class ColumnType
{
    // "Column Type" Constants.

    // STRING.

    const CT_CHAR		 = 0;
    const CT_VARCHAR 	  	 = 1;
    const CT_TINYTEXT     	 = 2;
    const CT_TEXT    	  	 = 3;
    const CT_MEDIUMTEXT   	 = 4;
    const CT_LONGTEXT     	 = 5;
    const CT_BINARY		 = 6;
    const CT_VARBINARY    	 = 7;
    const CT_TINYBLOB	  	 = 8;
    const CT_MEDIUMBLOB	  	 = 9;
    const CT_BLOB		 = 10;
    const CT_LONGBLOB	  	 = 11;
    const CT_ENUM		 = 12;
    const CT_SET		 = 13;

    // NUMERIC.

    const CT_INT     	 	 = 14;
    const CT_TINYINT     	 = 15;
    const CT_SMALLINT     	 = 16;
    const CT_MEDIUMINT	  	 = 17;
    const CT_BIGINT	      	 = 18;
    const CT_DECIMAL	  	 = 19;
    const CT_FLOAT	      	 = 20;
    const CT_REAL		 = 21;
    const CT_BIT		 = 22;
    const CT_BOOLEAN	  	 = 23;
    const CT_SERIAL		 = 24;

    // DATE AND TIME.

    const CT_DATE		 = 25;
    const CT_DATETIME     	 = 26;
    const CT_TIMESTAMP           = 27;
    const CT_TIME		 = 28;
    const CT_YEAR		 = 29;

    // SPATIAL.

    const CT_GEOMETRY    	= 30;
    const CT_POINT		= 31;
    const CT_LINESTRING   	= 32;
    const CT_POLYGON	  	= 33;
    const CT_MULTIPOINT   	= 34;
    const CT_MULTILINESTRING 	= 35;
    const CT_MULTIPOLYGON       = 36;
    const CT_GEOMETRYCOLLECTION = 37;
	
    // "Core" Variables.

    private $identArray = array
    (
        "CHAR",
        "VARCHAR",
        "TINYTEXT",
        "TEXT",
        "MEDIUMTEXT",
        "LONGTEXT",
        "BINARY",
        "VARBINARY",
        "TINYBLOB",
        "MEDIUMBLOB",
        "BLOB",
        "LONGBLOB",
        "ENUM",
        "SET",
        "INT",
        "TINYINT",
        "SMALLINT",
        "MEDIUMINT",
        "BIGINT",
        "DECIMAL",
        "FLOAT",
        "REAL",
        "BIT",
        "BOOLEAN",
        "SERIAL",
        "DATE",
        "DATETIME",
        "TIMESTAMP",
        "TIME",
        "YEAR",
        "GEOMETRY",
        "POINT",
        "LINESTRING",
        "POLYGON",
        "MULTIPOINT",
        "MULTILINESTRING",
        "MULTIPOLYGON",
        "GEOMETRYCOLLECTION"
    );

    private $typeSelected = null;
    private $typeIdent    = null;
    private $lengthValue  = null;

    // Constructor/s.

    public function __construct($value = null)
    {
        if ($value != null)
        {
            $args = func_get_args();

            if (count($args) == 3)
            {
                $this->typeSelected = $args[0];
                $this->lengthValue  = $args[1];
                $this->typeIdent    = $args[2];
            }
            else
                new Notice("ColumnType", "You have passed wrong set of parameters in the constructor.");
        }
    }
	
    // "Use" Methods for "STRING" type.

    public static function useChar($vl = null)
    {
        return new self(self::CT_CHAR, $vl, "CHAR");
    }

    public static function useVarChar($vl = null)
    {
        return new self(self::CT_VARCHAR, $vl, "VARCHAR");
    }

    public static function useTinyText($vl = null)
    {
        return new self(self::CT_TINYTEXT, $vl, "TINYTEXT");
    }

    public static function useText($vl = null)
    {
        return new self(self::CT_TEXT, $vl, "TEXT");
    }

    public static function useMediumText($vl = null)
    {
        return new self(self::CT_MEDIUMTEXT, $vl, "MEDIUMTEXT");
    }
	
    public static function useLongText($vl = null)
    {
        return new self(self::CT_LONGTEXT, $vl, "LONGTEXT");
    }

    public static function useBinary($vl = null)
    {
        return new self(self::CT_BINARY, $vl, "BINARY");
    }

    public static function useVarBinary($vl = null)
    {
        return new self(self::CT_VARBINARY, $vl, "VARBINARY");
    }

    public static function useTinyBlob($vl = null)
    {
        return new self(self::CT_TINYBLOB, $vl, "TINYBLOB");
    }

    public static function useMediumBlob($vl = null)
    {
        return new self(self::CT_MEDIUMBLOB, $vl, "MEDIUMBLOB");
    }

    public static function useBlob($vl = null)
    {
        return new self(self::CT_BLOB, $vl, "BLOB");
    }
	
    public static function useLongBlob($vl = null)
    {
        return new self(self::CT_LONGBLOB, $vl, "LONGBLOB");
    }

    public static function useEnum($vl = null)
    {
        return new self(self::CT_ENUM, $vl, "ENUM");
    }

    public static function useSet($vl = null)
    {
        return new self(self::CT_SET, $vl, "SET");
    }

    // "Use" Methods for "NUMERIC" type.

    public static function useInt($vl = null)
    {
        return new self(self::CT_INT, $vl, "INT");
    }

    public static function useTinyInt($vl = null)
    {
        return new self(self::CT_TINYINT, $vl, "TINYINT");
    }

    public static function useSmallInt($vl = null)
    {
        return new self(self::CT_SMALLINT, $vl, "SMALLINT");
    }

    public static function useMediumInt($vl = null)
    {
        return new self(self::CT_MEDIUMINT, $vl, "MEDIUMINT");
    }

    public static function useBigInt($vl = null)
    {
        return new self(self::CT_BIGINT, $vl, "BIGINT");
    }

    public static function useDecimal($vl = null)
    {
        return new self(self::CT_DECIMAL, $vl, "DECIMAL");
    }

    public static function useFloat($vl = null)
    {
        return new self(self::CT_FLOAT, $vl, "FLOAT");
    }

    public static function useReal($vl = null)
    {
        return new self(self::CT_REAL, $vl, "REAL");
    }

    public static function useBit($vl = null)
    {
        return new self(self::CT_BIT, $vl, "BIT");
    }

    public static function useBoolean($vl = null)
    {
        return new self(self::CT_BOOLEAN, $vl, "BOOLEAN");
    }
	
    public static function useSerial($vl = null)
    {
        return new self(self::CT_SERIAL, $vl, "SERIAL");
    }
	
    // "Use" Methods for "DATE AND TIME" type.

    public static function useDate($vl = null)
    {
        return new self(self::CT_DATE, $vl, "DATE");
    }

    public static function useDateTime($vl = null)
    {
        return new self(self::CT_DATETIME, $vl, "DATETIME");
    }

    public static function useTimeStamp($vl = null)
    {
        return new self(self::CT_TIMESTAMP, $vl, "TIMESTAMP");
    }

    public static function useTime($vl = null)
    {
        return new self(self::CT_TIME, $vl, "TIME");
    }

    public static function useYear($vl = null)
    {
        return new self(self::CT_YEAR, $vl, "YEAR");
    }
	
    // "Use" Methods for "SPATIAL" type.

    public static function useGeometry($vl = null)
    {
        return new self(self::CT_GEOMETRY, $vl, "GEOMETRY");
    }

    public static function usePoint($vl = null)
    {
        return new self(self::CT_POINT, $vl, "POINT");
    }

    public static function useLineString($vl = null)
    {
        return new self(self::CT_LINESTRING, $vl, "LINESTRING");
    }

    public static function usePolygon($vl = null)
    {
        return new self(self::CT_POLYGON, $vl, "POLYGON");
    }

    public static function useMultiPoint($vl = null)
    {
        return new self(self::CT_MULTIPOINT, $vl, "MULTIPOINT");
    }
	
    public static function useMultiLineString($vl = null)
    {
        return new self(self::CT_MULTILINESTRING, $vl, "MULTILINESTRING");
    }

    public static function useMultiPolygon($vl = null)
    {
        return new self(self::CT_MULTIPOLYGON, $vl, "MULTIPOLYGON");
    }

    public static function useGeometryCollection($vl = null)
    {
        return new self(self::CT_GEOMETRYCOLLECTION, $vl, "GEOMETRYCOLLECTION");
    }
	
    // "Set" Methods.

    public function setNumericTypeIdentificator($value)
    {
        if (is_numeric($value))
        {
            $this->typeSelected = $value;

            $this->typeIdent    = $this->identArray[$value];
        }
        else
            new Notice("ColumnType", "Identificator you've tried to set does not exist in SQL. It was not set.");
    }

    public function setTextualTypeIdentificator($value)
    {
        $foundType = false;

        foreach ($this->identArray as $arrayValue)
        {
            if ($value == $arrayValue)
            {
                $foundType = true;

                break;
            }
        }

        if ($foundType)
        {
            $this->typeSelected = constant("ColumnType::CT_" . $value);
            $this->typeIdent    = $value;
        }
        else
            new Notice("ColumnType", "Identificator you've tried to set does not exist in SQL. It was not set.");
    }
	
    public function setLengthValue($value)
    {
        $this->lengthValue = $value;
    }
	
    // "Get" Methods.

    public function getNumericTypeIdentificator()
    {
        return $this->typeSelected;
    }

    public function getTextualTypeIdentificator()
    {
        return $this->typeIdent;
    }

    public function getLengthValue()
    {
        return $this->lengthValue;
    }
}

?>
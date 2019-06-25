<?php 

class Db_objects {


public static function find_all(){

	return static::find_by_query("SELECT * FROM ". static::$db_table ." ");
}

public static function find_by_id($id){


	$the_result_array = static::find_by_query("SELECT * FROM ". static::$db_table ." where id = $id LIMIT 1");

	return !empty($the_result_array) ? array_shift($the_result_array) : false;

	// if(!empty($the_result_array)){

	// 	return array_shift($the_result_array);
	// }else{

	// 	return false;
	// }

}

public static function find_by_query($sql){

	global $database;

	$result_set = $database->query($sql);

	$the_object_array = array();

	while ($row = $result_set->fetch_array()) {
		# code...
		$the_object_array[] = static::instantiation($row);
	}

	return $the_object_array;

} // end method find_by_query

public static function instantiation($the_record){

	$calling_class = get_called_class();

	$the_object = new $calling_class;

	foreach ($the_record as $attribute_key => $value) {
		# code...

		if($the_object->has_the_attribute($attribute_key)){

			$the_object->$attribute_key = $value;

		}
	}

    return $the_object;
                        
} // end method instantiation

private function has_the_attribute($attribute_key){

	//$object_properties = get_object_vars($this);

	//return array_key_exists($attribute_key, $object_properties);

	return array_key_exists($attribute_key, get_object_vars($this));


} // end method as_the_attribute

/*public static function instantiation($found_user){

	$the_object             = new self;

    $the_object->id         = $found_user['id'];

    $the_object->username   = $found_user['username'];

    $the_object->password    = $found_user['password'];

    $the_object->first_name = $found_user['first_name'];

    $the_object->last_name  = $found_user['last_name'];

    return $the_object;

                        
}*/

public function save(){

	return ($this->id) ? $this->update() : $this->create();
}// END OF METHOD SAVE

protected function properties(){

	//return get_object_vars($this);

	$properties = array();

	foreach (static::$db_table_fields as $db_table_field) {
		# code...
		if(property_exists($this, $db_table_field)){

			$properties[$db_table_field] = $this->$db_table_field;
		}
	}

	return $properties;
} // end method properties

protected function clean_properties(){
	global $database;

	$clean_properties = array();

	foreach ($this->properties() as $key => $value) {
		# code...

		$clean_properties[$key] = $database->escape_string($value);
	}

	return $clean_properties;


}// end method clean_properties

public function create(){
	global $database;

	$properties = $this->clean_properties();

	$sql = "INSERT INTO ". static::$db_table ." (". implode(" , ", array_keys($properties)) .") ";
	$sql .= "VALUES ('". implode("' , '", array_values($properties)) ."')";

	//return $sql;

	if($database->query($sql)){

		$this->id = $database->the_insert_id();
		return true;

	} else{

		return false;
	}

} // END OF METHOD CREATE

public function update(){
	global $database;

	$properties = $this->clean_properties();

	$properties_pairs = array();

	foreach ($properties as $key => $value) {
		# code...
		$properties_pairs[] = "{$key} = '{$value}'";
	}
	 
	$sql = "UPDATE ". static::$db_table ." SET ";
	$sql .= implode(', ', $properties_pairs);
	$sql .= " WHERE id = ".$database->escape_string($this->id);

	//$database->query($sql);

	//return $sql;

	return ($database->query($sql) && $database->the_affected_rows() == 1) ? true : false;


}// END OF METHOD UPDATE

public function delete(){
	global $database;

	$sql = "DELETE FROM ". static::$db_table ." ";
	$sql .= "WHERE id = " . $database->escape_string($this->id);
	$sql .= " LIMIT 1";

	return ($database->query($sql) && $database->the_affected_rows() == 1) ? true : false;

}// END OF METHOD DELETE









}










?>
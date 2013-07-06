<?php 

return array(

	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines contain the default error messages used
	| by the validator class. Some of the rules contain multiple versions,
	| such as the size (max, min, between) rules. These versions are used
	| for different input types such as strings and files.
	|
	| These language lines may be easily changed to provide custom error
	| messages in your application. Error messages for custom validation
	| rules may also be added to this file.
	|
	*/

	"accepted"       => ":attribute de ser valido.",
	"active_url"     => ":attribute no es una URL valida.",
	"after"          => ":attribute debe ser una fecha posterior a :date.",
	"alpha"          => ":attribute solo debe contener letras.",
	"alpha_dash"     => ":attribute solo debe contener letras, números o guiones.",
	"alpha_num"      => ":attribute solo debe contener letras o números.",
	"array"          => ":attribute debe seleccionar un elemento de la lista.",
	"before"         => ":attribute ebe ser una fecha anterior a :date.",
	"between"        => array(
		"numeric" => ":attribute debe estar entre :min - :max.",
		"file"    => ":attribute debe estar entre :min - :max kilobytes.",
		"string"  => ":attribute debe estar entre :min - :max caracteres.",
	),
	"confirmed"      => ":attribute no concuerda.",
	"count"          => ":attribute debe tener exactamente :count elementos seleccionados.",
	"countbetween"   => ":attribute debe estar entre :min y :max elementos seleccionados.",
	"countmax"       => ":attribute debe tener máximo :max elementos seleccionados.",
	"countmin"       => ":attribute debe tener al menos :min elementos seleccionados.",
	"date_format"	 => ":attribute debe tener un formato de fecha valido.",
	"different"      => ":attribute y :other deben ser diferentes.",
	"email"          => ":attribute no es valido.",
	"exists"         => ":attribute seleccionado no es valido.",
	"image"          => ":attribute debe ser una imagen.",
	"in"             => ":attribute seleccionado no es valido.",
	"integer"        => ":attribute debe ser un número entero.",
	"ip"             => ":attribute debe ser una dirección ip valida.",
	"match"          => ":attribute no es valido.",
	"max"            => array(
		"numeric" => ":attribute debe ser menor a :max.",
		"file"    => ":attribute debe ser menor a :max kilobytes.",
		"string"  => ":attribute debe tener máximo :max caracteres.",
	),
	"mimes"          => ":attribute debe ser un archivo de tipo: :values.",
	"min"            => array(
		"numeric" => ":attribute debe ser mayor a :min.",
		"file"    => ":attribute debe ser mayor a :min kilobytes.",
		"string"  => ":attribute debe tener minimo :min caracteres.",
	),
	"not_in"         => ":attribute no es valido.",
	"numeric"        => ":attribute debe ser numerico.",
	"required"       => ":attribute es requerido.",
    "required_with"  => ":attribute es requerido con :field",
	"same"           => ":attribute y :other deben ser iguales.",
	"size"           => array(
		"numeric" => ":attribute debe ser :size.",
		"file"    => ":attribute debe ser :size kilobyte.",
		"string"  => ":attribute debe tener :size caracteres.",
	),
	"unique"         => ":attribute debe ser único.",
	"url"            => ":attribute no es valido.",

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention "attribute_rule" to name the lines. This helps keep your
	| custom validation clean and tidy.
	|
	| So, say you want to use a custom validation message when validating that
	| the "email" attribute is unique. Just add "email_unique" to this array
	| with your custom message. The Validator will handle the rest!
	|
	*/

	'custom' => array(),

	/*
	|--------------------------------------------------------------------------
	| Validation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap attribute place-holders
	| with something more reader friendly such as "E-Mail Address" instead
	| of "email". Your users will thank you.
	|
	| The Validator class will automatically search this array of lines it
	| is attempting to replace the :attribute place-holder in messages.
	| It's pretty slick. We think you'll like it.
	|
	*/

	'attributes' => array(),

);

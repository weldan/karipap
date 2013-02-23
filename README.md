##karipap
==========

![karipap](http://goo.gl/WnUpZ)

not sure what i try to achieve, but it is working. feel free to use/modify/adapt it whatever you like.


##connect
==========
```php
$db = new Karipap($database, $user, $pass, $host);
```

##raw query
==========
```php
$db->raw("select * from table");
```

##prepared statement query
```php
$db->query("select * from table where column = ?", array($column));
$db->query("update table set column = :value where column = :column", array(':value' => $value, ':column' => $column));
```

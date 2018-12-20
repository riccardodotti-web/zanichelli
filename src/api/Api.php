<?php

//Api.php

class API
{
	private $connect = '';

	function __construct()
	{
		$this->database_connection();
	}

	function database_connection()
	{
            try {
		$this->connect = new PDO("mysql:host=localhost;dbname=zanichelli","root","");
            } catch (PDOException $e) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }

	}

	function fetch_all()
	{
            $query = "SELECT * FROM clients ORDER BY id";
            $statement = $this->connect->prepare($query);
            if($statement->execute()):
                while($row = $statement->fetch(PDO::FETCH_ASSOC)):
                    $data[] = $row;
                endwhile;
                return $data;
            endif;
	}

	function insert()
	{
            if(isset($_POST["first_name"])):
                $form_data = array(
                    ':first_name'		=>	$_POST["first_name"],
                    ':last_name'		=>	$_POST["last_name"]
		);
		$query = "
                    INSERT INTO clients 
                    (first_name, last_name) VALUES 
                    (:first_name, :last_name)
		";
		$statement = $this->connect->prepare($query);
		if($statement->execute($form_data)):
                    $data[] = array(
                        'success'	=>	'201'
                    );
		else:
                    $data[] = array(
                        'success'	=>	'404'
                    );
                endif;
            else:
                $data[] = array(
                    'success'	=>	'400'
                );
            endif;
            return $data;
	}

	function fetch_single($id)
	{
            $query = "SELECT * FROM clients WHERE id='".$id."'";
            $statement = $this->connect->prepare($query);
            if($statement->execute()):
                foreach($statement->fetchAll() as $row):
                    $data['first_name'] = $row['first_name'];
                    $data['last_name'] = $row['last_name'];
                endforeach;
                return $data;
            endif;
	}

	function update()
	{
            if(isset($_POST["first_name"])):
                $form_data = array(
                    ':first_name'	=>	$_POST['first_name'],
                    ':last_name'	=>	$_POST['last_name'],
                    ':id' => $_POST['id']
                );
                $query = "UPDATE clients 
                          SET first_name = :first_name, last_name = :last_name 
                          WHERE id = :id";
                $statement = $this->connect->prepare($query);
                if($statement->execute($form_data)):
                    $data[] = array(
                        'success'	=>	'200'
                    );
                else:
                    $data[] = array(
                        'success'	=>	'404'
                    );
                endif;
            else:
                $data[] = array(
                    'success'	=>	'400'
                );
            endif;
            return $data;
	}
	function delete($id)
	{
            $query = "DELETE FROM clients WHERE id = '".$id."'";
            $statement = $this->connect->prepare($query);
            if($statement->execute()):
                $data[] = array(
                    'success'	=>	'204'
                );
            else:
                $data[] = array(
                    'success'	=>	'404'
                );
            endif;
            return $data;
	}
}

?>

<?php
	require_once('connection.php');

/*
problems in sponsor_title database: the numbers are all wrong
Also titleId in spons_list corresponds to the relaevant title not order_no

*/
  class Product {
    
    public $sno;
    public $sub_title;
    public $name;
    public $link_img;
    public $link_web;
    public $title_id;
    public $year;
    public $order_no;

    public function __construct($sno, $sub_title, $name, $link_img, $link_web, $title_id, $year, $order_no) {
      $this->sno      = $sno;
      $this->sub_title  = $sub_title;
      $this->name=$name;
      $this->link_img=$link_img;
      $this->link_web=$link_web;
      $this->title_id=$title_id;
      $this->year = $year;
      $this->order_no = $order_no;
    }

    public static function find($year) {
      $db = Db::getInstance();

      $year = intval($year);

      $req = $db->prepare('SELECT * FROM spons_list WHERE year = :year ORDER BY title_id');
      $req->execute(array('year' => $year));
      

      foreach($req->fetchAll() as $product) {
        $list[] = new product($product['sno'], $product['sub_title'], $product['name'], $product['link_img'], $product['link_web'], $product['title_id'],$product['year'], $product['order_no']);
      }

      return $list;
    }
  }


  class titles {
    
    public $id;
    public $title;
    public $number;
    public $sizeTitle;
    public $year;
    public $order_no;

    public function __construct($id, $title, $number, $sizeTitle, $year, $order_no) {
      $this->id      = $id;
      $this->title  = $title;
      $this->sizeTitle=$sizeTitle;
      $this->year=$year;
      $this->order_no=$order_no;
      $this->number=$number;
    }

    public static function find($year) {
      $db = Db::getInstance();

      $year = intval($year);

      $req = $db->prepare('SELECT * FROM spons_title WHERE year = :year');
      $req->execute(array('year' => $year));
      

      foreach($req->fetchAll() as $titles) {
        $list[] = new titles($titles['id'], $titles['title'], $titles['number'], $titles['sizeTitle'], $titles['year'], $titles['order_no']);
      }

      return $list;
    }
  }



?>

<?php
	echo "<h1 style = 'font-size: 7vw;'>". $_POST['year']."</h1>";


  $test = Product::find($_POST['year']);
  $heading = titles::find($_POST['year']);
  $it = 0;

  // // foreach ($heading as $hd) 
  // // {
  // 	echo '<br><h1>'.$heading[0]->title.'</h1>';
  // 	echo '<br><h1>'.$heading[1]->title.'</h1>';
  // // }
  $temp = -1;
  foreach ($test as $data) 
  {
  		if($data->title_id != $temp)
  		{
  			echo '<br><h1>'.$heading[$it]->title.'</h1>';
  			$it = $it + 1;
  		}
  		 
		echo 
		'<div class="col-md-4 col-sm-6 portfolio-item" style="margin:auto;">
		<a href="'.$data->link_web.'">
			<img class = "img-fluid" src="'.$data->link_img.'"  alt = "'.$data->name.'">
		</a>
		';
		if($data->sub_title != '')
		{
		 	echo '<p class="text-muted">'.$data->sub_title.'</p>';
		}
		echo '</div>';
		$temp = $data->title_id;
  }
  // if the link is empty put sf website in place of the original using the $_GLOBAL[''] variable
?>

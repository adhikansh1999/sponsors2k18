<?php
	require_once('connection.php');


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

    public static function all() {
      $list = [];
      $db = Db::getInstance();
      $req = $db->query('SELECT * FROM spons_list');

      foreach($req->fetchAll() as $product) {
        $list[] = new product($product['sno'], $product['sub_title'], $product['name'], $product['link_img'], $product['link_web'], $product['title_id'],$product['year'], $product['order_no']);
      }

      return $list;
    }

    public static function find($year) {
      $db = Db::getInstance();

      $year = intval($year);

      $req = $db->prepare('SELECT * FROM spons_list WHERE year = :year');
      $req->execute(array('year' => $year));
      

      foreach($req->fetchAll() as $product) {
        $list[] = new product($product['sno'], $product['sub_title'], $product['name'], $product['link_img'], $product['link_web'], $product['title_id'],$product['year'], $product['order_no']);
      }

      return $list;
    }
  }

?>

<?php
	echo "the year is  <h1>". $_POST['year']."</h1>";


  $test = Product::find($_POST['year']);

  echo '<br><br><br>'.sizeof($test);

  foreach ($test as $data) 
  {
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
  }
  // if the link is empty put sf website in place of the original using the $_GLOBAL[''] variable
?>

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

    public static function find($title_id,$year) {
      $db = Db::getInstance();

      $year = intval($year);

      $req = $db->prepare('SELECT * FROM spons_list WHERE title_id=:title_id  AND year = :year ORDER BY order_no');
      $req->execute(array(':title_id'=>$title_id,'year' => $year));
      
      $list = [];
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

      $req = $db->prepare('SELECT * FROM spons_title WHERE year = :year ORDER by order_no');
      $req->execute(array(':year' => $year));
      
      foreach($req->fetchAll() as $titles) {
        $list[] = new titles($titles['id'], $titles['title'], $titles['number'], $titles['sizeTitle'], $titles['year'], $titles['order_no']);
      }

      return $list;
    }
  }



?>

<?php
	echo "<h1 style = 'font-size: 7vw;'>". $_POST['year']."</h1>";

  $heading_list = titles::find($_POST['year']);
  $triple_grouping = array("EVENT SPONSORS","EVENT SPONSOR","ONLINE MEDIA PARTNERS","ONLINE MEDIA PARTNER","MAGAZINE PARTNER","MAGAZINE PARTNERS","EVENT ASSOCIATIONS","EVENT ASSOCIATION","GIFT PARTNERS","GIFT PARTNER");


  foreach ($heading_list as $title) 
  {
    $spons_list[$title->id]=Product::find($title->id,$_POST['year']);
  }

  foreach ($heading_list as $title) 
  {
    echo '<div class ="row"><div class = "col-12 text-center"><br><h1>'.$title->title.'</h1></div></div>';
    if(in_array($title->title, $triple_grouping))
    {
      // echo '<div class ="row">3 in a row</div>';
      $it = 0;
      foreach ($spons_list[$title->id] as $data) 
      {
        if($it%3 == 0){
        echo '<div class = "row">';}
        echo '  <div class="col-4" style= "margin:auto;">
                <a href="'.$data->link_web.'">
                  <img class = "img-fluid" src="'.$data->link_img.'"  alt = "'.$data->name.'">
                </a>
              ';
        if($data->sub_title != ''){
          echo '<p class="text-muted">'.$data->sub_title.'</p>';
        }
        echo '</div>';

        if($it%3 == 2){
        echo '</div>';
        }
        $it = $it + 1;
      }
      if($it%3 != 0)
      {
        echo '</div>';
      }

    }
    else{
      foreach ($spons_list[$title->id] as $data) 
      {
        echo '<div class ="row"><div class="col-md-4 col-md-offset-4 text-center" style="margin:auto;">
                <a href="'.$data->link_web.'">
                  <img class = "img-fluid" src="'.$data->link_img.'"  alt = "'.$data->name.'">
                </a>
              ';
        if($data->sub_title != ''){
          echo '<p class="text-muted">'.$data->sub_title.'</p>';
        }
        echo '</div></div>';
      }
    }
  }
?>

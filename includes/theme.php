<?php
/* --------------------------------------------------- THEME */



/* add_page_info()
 * temaya ozel menu ve title ekler
 */
function add_page_info($name='', $value) {
	if($name == 'nav') {
		til()->page[$name][] = $value;
	} else {
		til()->page[$name] = $value;
	}
}






/** 
 * get_page_info()
 * bir sayfa bilgisini dondurur
 */
function get_page_info($name) {
	if(isset(til()->page[$name])) {
		return til()->page[$name];
	} else { return false; }
}






/* set_page_info()
 * temaya nav menu ve title ekler
 */
function set_page_info($arr='')
{
	if(!isset(til()->page)) {
		til()->page['title'] = 'Tilpark!';
	}

	if(isset(til()->page)) {
		$arr = til()->page;

		?><script>$(document).ready(function(){ <?php
		if(is_array(@$arr['nav'])) {
			foreach($arr['nav'] as $nav)
			{
				if(!isset($nav['url']) or $nav['url'] == ''):
					?> $(".breadcrumb").append( '<li class="active"><?php echo $nav['name']; ?></li>' ); <?php
				else:
					?> $(".breadcrumb").append( '<li><a href="<?php echo $nav['url']; ?>"><?php echo $nav['name']; ?></a></li>' ); <?php
				endif;
			}
		}

		if(!isset($arr['title'])) { $arr['title'] = 'Deneme'; }

		if(isset($arr['title'])) {
			if(strlen($arr['title']) < 1) { $arr['title'] = 'Tilpark!'; }
			?>
				$('h3.page-title').html('<?php echo $arr["title"]; ?>'); 
				document.title = "<?php echo $arr["title"]; ?> | Tilpark!";
			<?php
		}

		?>}); </script> <?php
	} else {
		return false;
	}

}



/**
 * get_table_order_by()
 * table listelemelerinde thead->tr->th icerisine order by eklemek icin kullanılabilir.
 */
function get_table_order_by($name='', $orderby_type='') {

	$icon = 'long-arrow-down';
	$class = 'text-muted';
	if(@$_GET['orderby_name'] == $name) {
		$class='text-success';
		if(@$_GET['orderby_type'] == 'DESC') {
			$orderby_type = 'ASC';
			$icon = 'long-arrow-up';
		}
		if(@$_GET['orderby_type'] == 'ASC') {
			$orderby_type = 'DESC';
			$icon = 'long-arrow-down';
		}
	}
	$url = get_set_url_parameters( array('add'=> array('orderby_name'=>$name, 'orderby_type'=>$orderby_type) ) );

	$return = '<a href="'.$url.'" class="pull-right orderby '.$class.'"><i class="fa fa-'.$icon.'" aria-hidden="true"></i></a>';

	return $return;
}







/**
 * pagination()
 * listelemelerde sıralamalar icin kullanılır
 */
function pagination($count) {

	$paged = ceil($count / til()->pg->list_limit); 
	if(isset($_GET['page'])) {
		$page = $_GET['page'];
	} else {
		$page = 1;
	}


	$btn_back = '#';
	$btn_next = '#';
	$btn_after = '#';
	$btn_before = '#';


	if($page > 1) {
		$btn_back = get_set_url_parameters( array('add'=> array('page'=>$page-1) ) );
	}

	if($page < $paged) {
		$btn_next = get_set_url_parameters( array('add'=> array('page'=>$page+1) ) );
	}

	if($page > 4) {
		$btn_after = get_set_url_parameters( array('add'=> array('page'=>1) ) );
	}

	if($paged > 4 and $page < ($paged - 3) ) {
		$btn_before = get_set_url_parameters( array('add'=> array('page'=>$paged) ) );
	}



	?>

	<nav aria-label="Page navigation" class="text-center">
	  <ul class="pagination">
	  	<?php if($btn_after != '#'): ?>
	  		<li class="<?php if($btn_after == '#'): ?>disabled<?php endif; ?>">
	      		<a href="<?php echo $btn_after; ?>" aria-label="Previous">
	        		<span aria-hidden="true"><i class="fa fa-angle-double-left" aria-hidden="true"></i> İlk Sayfa</span>
	     		</a>
	    	</li>
	    <?php endif; ?>
	    <li class="<?php if($btn_back == '#'): ?>disabled<?php endif; ?>">
	      <a href="<?php echo $btn_back; ?>" aria-label="Previous">
	        <span aria-hidden="true"><i class="fa fa-angle-double-left" aria-hidden="true"></i></span>
	      </a>
	    </li>
	    
	    <?php if(($page-3) > 0): ?> <li><a href="<?php echo get_set_url_parameters(array('add'=> array('page'=>$page-3))); ?>"><?php echo $page-3; ?></a></li> <?php endif; ?>
	    <?php if(($page-2) > 0): ?> <li><a href="<?php echo get_set_url_parameters(array('add'=> array('page'=>$page-2))); ?>"><?php echo $page-2; ?></a></li> <?php endif; ?>
	    <?php if(($page-1) > 0): ?> <li><a href="<?php echo get_set_url_parameters(array('add'=> array('page'=>$page-1))); ?>"><?php echo $page-1; ?></a></li> <?php endif; ?>
	    <li class="active"><a href="#"><?php echo $page; ?></a></li>
	    <?php if(($page+1) <= $paged): ?> <li><a href="<?php echo get_set_url_parameters(array('add'=> array('page'=>$page+1))); ?>"><?php echo $page+1; ?></a></li> <?php endif; ?>
	    <?php if(($page+2) <= $paged): ?> <li><a href="<?php echo get_set_url_parameters(array('add'=> array('page'=>$page+2))); ?>"><?php echo $page+2; ?></a></li> <?php endif; ?>
	    <?php if(($page+3) <= $paged): ?> <li><a href="<?php echo get_set_url_parameters(array('add'=> array('page'=>$page+3))); ?>"><?php echo $page+3; ?></a></li> <?php endif; ?>
	    
	    <li class="<?php if($btn_back == '#'): ?>disabled<?php endif; ?>">
	      <a href="<?php echo $btn_back; ?>" aria-label="Previous">
	        <span aria-hidden="true"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
	      </a>
	    </li>
	    <?php if($btn_before != '#'): ?>
	    	<li class="<?php if($btn_before == '#'): ?>disabled<?php endif; ?>">
	      		<a href="<?php echo $btn_before; ?>" aria-label="Previous">
	        	<span aria-hidden="true">Son Sayfa <i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
	      		</a>
	    	</li>
	    <?php endif; ?>
	  </ul>
	</nav>
	<?php
}





/**
 * search_form_for_panel()
 * panel görünümünde panel header içerisinde arama bölümü ekler
 */
function search_form_for_panel($arr=array()) {

	if(!isset($arr['s_name'])) { $arr['s_name'] = 'default'; }
	?>
	<form name="form_panel_search_<?php echo $arr['s_name']; ?>" id="form_panel_search_<?php echo $arr['s_name']; ?>" action="" method="GET" class="panel-search">
		<div class="input-group">
			<div class="input-group-btn">
				<?php if( isset($arr['db-s-where']) ): ?>
				    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="btn-text">Genel</span> <span class="caret"></span></button>
				    <ul class="dropdown-menu dropdown-menu-left" role="menu">
				    	<li><a href="#" data-click="db-search" data-db-table-name="all">Genel</a></li>
				    	<li role="separator" class="divider"></li>
				    	<li class="dropdown-header"><i class="fa fa-database"></i> ÖZEL SORGU</li>
				    	<?php foreach($arr['db-s-where'] as $sWhere): ?>
				    		<li><a href="#" data-click="db-search" data-db-table-name="<?php echo $sWhere['val']; ?>"><?php echo $sWhere['name']; ?></a></li>
				    	<?php endforeach; ?>
				    </ul>
				<?php endif; ?>
		  </div><!-- /btn-group -->
		  <input type="text" name="s" id="panel_s_<?php echo $arr['s_name']; ?>" class="form-control" placeholder="arama yapın" value="<?php echo @$_GET['s']; ?>">
		  <div class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-search"></i></span></button></div>
		  
		</div><!-- /input-group -->

		<script>
		$(document).ready(function() {
			$('#form_panel_search_<?php echo $arr["s_name"]; ?> [data-click="db-search"]').click(function() {	
				$(this).parent().parent().parent().find('.btn span.btn-text').html($(this).html());
				var db_table_name = $(this).attr('data-db-table-name');
				$(this).parent().parent().parent().parent().parent().parent().find('[name="db-s-where"]').val(db_table_name);
			});

			<?php if(isset($_GET['db-s-where'])): ?>
				$('#form_panel_search_<?php echo $arr["s_name"]; ?> [data-db-table-name="<?php echo $_GET["db-s-where"]; ?>"]').click();
			<?php endif; ?>
		});
		</script>
		<input type="hidden" name="db-s-where" id="db-where_<?php echo $arr['s_name']; ?>" value="all">
		<?php echo get_url_parameters_for_form( array('del'=>array('s'=>false, 'page'=>false, 'db-s-where'=>false)) ); ?>
	</form>
	<?php
}





/**
 * get_barcode_url()
 * barkod adresini URL formatında dondurur
 */
function get_barcode_url($val, $codeType='Code128', $print='false') {
	return site_url('includes/lib/barcode/barcode.php?codetype='.$codeType.'&text='.$val.'&print='.$print.'');
}
function barcode_url($val, $codeType='Code128', $print='false') {
	echo get_barcode_url($val, $codeType, $print);
}





/**
 * get_log_meta_for_table()
 * log metalarından gelen json kodlarını decode eder ve gosterir
 */
function get_log_meta_for_table($meta) {
	$meta = json_decode($meta);
	foreach($meta as $obj) {
		echo '<br /><small> <span class="text-danger">'.$obj->old.'</span> - <span class="text-success">'.$obj->new.'</span></small>';
	}
}





/**
 * get_theme_logs()
 * get_logs() fonksiyonundaki verileri "tilpark1" temasına gore suzer ve gosterir
 */
function theme_get_logs($query=array()) {
	$logs = get_logs($query); ?>
	<?php if($logs): ?>
		<table class="table table-hover table-condensed table-striped dataTable-logs">
			<thead>
				<tr>
					<th class="none"></th>
					<th width="120">Tarih</th>
					<th width="200">Kullanıcı</th>
					<th>Açıklama</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($logs as $log): ?>
				<tr>
					<td class="none"></td>
					<td>
						<?php echo get_time_late($log->date); ?> önce
						<br />
						<small class="text-muted"><?php echo $log->date; ?></small>
					</td>
					<td><span class="fs-12"><?php echo $log->name_surname; ?></span></td>
					<td>
						<span class="hidden"><?php echo $log->log_key; ?></span>
						<?php echo $log->log_text; ?>
						<?php if(isset($log->meta)): ?>

							<?php foreach($log->meta as $meta): ?>
								<?php echo get_log_meta_for_table($meta); ?>
							<?php endforeach; ?>

						<?php endif; ?>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table> 
	<?php else: ?>
		<?php print_alert('get_logs'); ?>
	<?php endif;
}





/**
 * create_modal()
 * bootstrap modal icin HTML ciktisi olusturur
 */
function create_modal($args=array()) {
	if(!isset($args['x'])) { $args['x'] = true; }
	if(!isset($args['header'])) { $args['header'] = true; }
	if(!isset($args['body'])) { $args['body'] = true; }
	if(!isset($args['footer'])) { $args['footer'] = true; }
	if(!isset($args['btn_close'])) { $args['btn_close'] = true; }
	?>
	<div class="modal fade" id="<?php echo $args['id']; ?>" tabindex="-1" role="dialog">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      	<?php if($args['header']): ?>
		      	<div class="modal-header">
		        	<?php if($args['x']): ?><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php endif; ?>
		        	<?php if(isset($args['title'])): ?><h4 class="modal-title" id="myModalLabel"><?php echo $args['title']; ?></h4><?php endif; ?>
		      	</div>
		    <?php endif; ?>
		    <?php if($args['body']): ?>
		      	<div class="modal-body">
		        	<?php echo $args['content']; ?>
		      	</div>
		    <?php endif; ?>
		    <?php if($args['footer']): ?>
	      		<div class="modal-footer">
	        		<?php if(isset($args['btn'])): ?><?php echo $args['btn']; ?><?php endif; ?>
	      		</div>
	      	<?php endif; ?>
	    </div>
	  </div>
	</div>
	<?php
} //.create_modal()






/* convert_bayt()
	@description: parametrede aldıgı degeri bayt cinsinden katmanlarina cevirir /; */
function convert_bayt($size)
{
    $unit=array('b','kb','mb','gb','tb','pb');
    return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
}






?>
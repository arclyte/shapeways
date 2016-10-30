<!DOCTYPE html>
<html lang="en">
  <head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Product Comments</title>

	<!-- Bootstrap -->
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
  </head>
  <body>
	<?php
		require "ProductComments.php";

		$ProductComments = new ProductComments();

		$added_id = false;
		if (!empty($_POST)) {
			if ($ProductComments->addComment($_POST)) {
				$added_id = $_POST['product_id'];
			}
		}

		$products = $ProductComments->getProducts();
		$users = $ProductComments->getUsers();

		
	?>
	<div class="container">
		<?php if ($added_id): ?>
		<div class="alert alert-success" role="alert">
			<strong>Comment Added</strong> You added a comment to Product <?php echo $added_id ?>
		</div>
		<?php endif ?>

		<h1>Add Product Comment</h1>

		<form id="comment_form" name="comment" method="post" action="">
			<div class="form-group">
				<label for="product_id">Product</label>
				<select class="form-control" id="product_id" name="product_id">
					<?php foreach ($products as $product): ?>
						<option value="<?php echo $product['id']; ?>">
							<?php echo $product['name']; ?>
						</option>
					<?php endforeach ?>
				</select>
			</div>

			<div class="form-group">
				<label for="user_id">User</label>
				<select class="form-control" id="user_id" name="user_id">
					<?php foreach ($users as $user): ?>
						<option value="<?php echo $user['id']; ?>">
							<?php echo $user['name']; ?>
						</option>
					<?php endforeach ?>
				</select>
			</div>
		
			<div class="form-group">
				<label for="comment">Comment</label>
				<textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
			</div>

			<button id="submit" class="btn btn-primary">Submit</button>
		</form>

		<h1>Unread Comments</h1>
		<div class="row col-md-3">
				<?php 
					foreach ($users as $user): 
						$unread_comments = $ProductComments->getUnreadCountForUser($user['id']);
				?>
					<h3><?php echo $user['name'] ?>:</h3>

					<?php
						if (!$unread_comments) {
							echo "No comments found.";
						}
						
						foreach ($unread_comments as $comment): 
					?>
			
						<table class="table">
							<tr>
								<td><?php echo $comment[0] ?></td>
								<td><?php echo $comment[1] ?></td>
							</tr>
						</table>
					<?php endforeach ?>

				<?php endforeach ?>
			
		</div>
	</div>

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

	<script>
		$('#comment_form').on('click', '#submit', function() {
			$('#comment_form').submit();
		})
	</script>
  </body>
</html>
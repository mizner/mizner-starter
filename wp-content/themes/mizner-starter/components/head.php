<?php

use Mizner\Theme\Schema;

$schema = new Schema();

?>
<!doctype html>
<html lang="en" <?php echo $schema->body(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>"/>
    <title><?php wp_title(); ?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<?php wp_head(); ?>
    <!--[if lt IE 9]>
    <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body <?php body_class(); ?>>
<?php get_template_part( 'images/font-awesome-sprites.svg' ); ?>

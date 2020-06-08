
<?php
use yii\helpers\Url;
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Turnos - Desligar.me</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="<?= Url::base(true) ?>/index/css/font-awesome.min.css" rel="stylesheet" type="text/css" media="all">
        <link href="<?= Url::base(true) ?>/index/css/themify-icons.css" rel="stylesheet" type="text/css" media="all" />
        <link href="<?= Url::base(true) ?>/index/css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
        <link href="<?= Url::base(true) ?>/index/css/flexslider.css" rel="stylesheet" type="text/css" media="all" />
        <link href="<?= Url::base(true) ?>/index/css/lightbox.min.css" rel="stylesheet" type="text/css" media="all" />
        <link href="<?= Url::base(true) ?>/index/css/ytplayer.css" rel="stylesheet" type="text/css" media="all" />
        <link href="<?= Url::base(true) ?>/index/css/theme-nearblack.css" rel="stylesheet" type="text/css" media="all" />
        <link href="<?= Url::base(true) ?>/index/css/custom.css" rel="stylesheet" type="text/css" media="all" />
        <link href='http://fonts.googleapis.com/css?family=Lato:300,400%7CRaleway:100,400,300,500,600,700%7COpen+Sans:400,500,600' rel='stylesheet' type='text/css'>
        <link href="http://fonts.googleapis.com/css?family=Roboto+Condensed:100,300,400,700,700italic" rel="stylesheet" type="text/css">
        <link href="<?= Url::base(true) ?>/index/css/font-robotocondensed.css" rel="stylesheet" type="text/css">
    </head>

    <body class="btn-rounded">
				
		<div class="nav-container">
		</div>
		
		<div class="main-container">
		<section class="cover fullscreen image-slider slider-all-controls controls-inside parallax">
		        <ul class="slides">
		            <li class="overlay image-bg">
		                <div class="background-image-holder">
		                    <img alt="image" class="background-image" src="<?= Url::base(true) ?>/index/img/turnos-1.jpg">
		                </div>
		                <div class="container v-align-transform">
		                    <div class="row">
		                        <div class="col-md-6 col-md-offset-6 col-sm-8 col-sm-offset-4">
		                            <h1 class="mb40 mb-xs-16 large">Sistema de<br>Turnos Web</h1>
		                            <h6 class="uppercase mb16">Sistema completo de administración de turnos</h6>
		                            <p class="lead mb40">La forma más eficiente de automatizar y gestionar turnos para tu empresa, con foco en el cliente final.</p>
		                            <a class="btn btn-lg" href="<?= Yii::$app->urlManager->createUrl(['user/login']) ?>">Ingresar</a>
		                        </div>
		                    </div>
		                    
		                </div>
		                
		            </li>
		        </ul>
		    </section><section>
				<div class="container">
					<div class="row">
						<div class="col-md-6 col-md-push-3 text-center">
							<div class="image-slider slider-paging-controls controls-outside">
								<ul class="slides">
									<li class="mb32">
										<img alt="App" src="<?= Url::base(true) ?>/index/img/turnos-2.png">
									</li>
									<li class="mb32">
										<img alt="App" src="<?= Url::base(true) ?>/index/img/turnos-3.png">
									</li>
									<li class="mb32">
										<img alt="App" src="<?= Url::base(true) ?>/index/img/turnos-4.png">
									</li>
								</ul>
							</div>
						</div>
						
						<div class="col-md-3 col-md-pull-6">
							<div class="mt80 mt-xs-80 text-right text-left-xs">
								<h5 class="uppercase bold mb16">Gestión exitosa</h5>
								<p class="fade-1-4">
									Brinda una herramienta optima y sencilla a tus clientes para que reserven turnos en los servicios brindados por tu empresa.
								</p>
							</div>
							
							<div class="mt80 mt-xs-0 text-right text-left-xs">
								<h5 class="uppercase bold mb16">fidelizar clientes</h5>
								<p class="fade-1-4">Ten un registro de todos tus clientes, centralizado en una base de datos dónde saber que tipo de servicios usan y con que frecuencia.
								</p>
							</div>
						</div>
						
						<div class="col-md-3">
							<div class="mt80 mt-xs-0">
								<h5 class="uppercase bold mb16">automatizar procesos</h5>
								<p class="fade-1-4">Deja de lado los procesos antiguos y tediosos usando un sistema que te permita hacer lo mismo pero mejor.</p>
							</div>
							
							<div class="mt80 mt-xs-0">
								<h5 class="uppercase bold mb16">disponibilidad completa</h5>
								<p class="fade-1-4">
									And you wont be able to use the app! Make sure you have the phone within close proximity at all times!
								</p>
							</div>
						</div>
					</div>
					
				</div>
				
			</section>
			
			<section>
		        <div class="container">
		            <div class="row">
		                <div class="col-sm-4 text-center">
		                    <div class="feature">
		                        <i class="icon fade-3-4 inline-block mb16 ti ti-announcement"></i>
		                        <h4>Recordatorios</h4>
		                        <p>Recuerda a tus clientes cuándo tienen turnos con horas de anterioridad.</p>
		                    </div>
		                </div>
		                <div class="col-sm-4 text-center">
		                    <div class="feature">
		                        <i class="icon fade-3-4 inline-block mb16 ti ti-headphone-alt"></i>
		                        <h4>Auto Gestión</h4>
		                        <p>
		                            Permite que tus clientes reserven sus propios turnos usando un link público e incluso incorporando el sistema a una web existente.</p>
		                    </div>
		                </div>
		                <div class="col-sm-4 text-center">
		                    <div class="feature">
		                        <i class="icon fade-3-4 inline-block mb16 ti ti-user"></i>
		                        <h4>Administración</h4>
		                        <p>Crea usuarios con roles de administración para que tus empleados puedan monitorear y administrar los turnos.</p>
		                    </div>
		                </div>
		            </div>
		            
		        </div>
		        
		    </section><section>
		        <div class="container">
		            <div class="row">
		                <div class="col-sm-6 col-md-5">
		                    <h4 class="uppercase">Contactanos</h4>
		                    <p>Envíanos un e-mail con información acerca tu empresa y cuales son tus expectativas sobre el sistema de turnos, estaremos encantados de darte acceso!</p>
		                    <hr>
		                    
		                    <hr>
		                    <p>
		                        <strong>E:</strong> turnos@desligar.me&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<br><strong>W:</strong> +54 9 11 2875 7248&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<br>
		                    </p>
		                </div>
		                <div class="col-sm-6 col-md-5 col-md-offset-1">
		                    <form class="form-email" data-success="Gracias, estaremos en contacto a la brevedad." data-error="Completa los campos.">
		                        <input type="text" class="validate-required" name="name" placeholder="Nombre">
		                        <input type="text" class="validate-required validate-email" name="email" placeholder="Emai">
		                        <textarea class="validate-required" name="message" rows="4" placeholder="Mensaje"></textarea>
		                        <button type="submit">Enviar</button>
		                    </form>
		                </div>
		            </div>
		            
		        </div>
		        
		    </section></div>
		
				
	<script src="<?= Url::base(true) ?>/index/js/jquery.min.js"></script>
        <script src="<?= Url::base(true) ?>/index/js/bootstrap.min.js"></script>
        <script src="<?= Url::base(true) ?>/index/js/flexslider.min.js"></script>
        <script src="<?= Url::base(true) ?>/index/js/lightbox.min.js"></script>
        <script src="<?= Url::base(true) ?>/index/js/masonry.min.js"></script>
        <script src="<?= Url::base(true) ?>/index/js/twitterfetcher.min.js"></script>
        <script src="<?= Url::base(true) ?>/index/js/spectragram.min.js"></script>
        <script src="<?= Url::base(true) ?>/index/js/ytplayer.min.js"></script>
        <script src="<?= Url::base(true) ?>/index/js/countdown.min.js"></script>
        <script src="<?= Url::base(true) ?>/index/js/smooth-scroll.min.js"></script>
        <script src="<?= Url::base(true) ?>/index/js/parallax.js"></script>
        <script src="<?= Url::base(true) ?>/index/js/scripts.js"></script>
    </body>
</html>
				
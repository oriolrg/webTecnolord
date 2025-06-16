function animacion_con_canvas() 
// creamos la función  animacion_con_canvas
{

	const mi_canvas = document.getElementById("canvas");
	// el elemento bautizado "canvas"  sera usado para crear la animaciòn

	const contexto = mi_canvas.getContext("2d");
	// creamos el contexto para poder animar en canvas
	// canvas soporta animaciones en 2d y en 3d, en este ejemplo usaremos animaciones 2d


	let img_palomita = new Image();
	// creamos un objeto del tipo imagen
	//  Como todo objeto tiene propiedades métodos y eventos

	img_palomita.src ="http://109.167.55.247:8001/record/current.jpg";
	// con la propiedad src definimos la imagen a cargar. DEBE ESCRIBIRSE LA RUTA CORRECTA A LA IMAGEN

	img_palomita.addEventListener('load', mostrar_imagen, false);
	// para poder mostrar la imagen, primero debe cargarse...
	// la imagen tienen el evento load, que se produce cuando la imagen se ha descargado en el navegador
	// el método EventListener permite verificar cuando la imagen se ha cargado
	// cuando la imagen se ha cargado ejecutaremos la función mostrar_imagen, que mostrará la imágen en el canvas
	// el método EventListener utiliza las variables (evento, función a ejecutar, indica si se desea iniciar el registro del evento)


	function mostrar_imagen() 
	// creamos la función  mostrar_imagen para mostrar la imagen en el canvas
	// esta función se ejecuta cuando la imagen se ha cargado
	{

		contexto.drawImage(img_palomita, 0, 0);	
		// aqui utilizamo el método drawimage para mostrar a nuestra imagen dentro del canvas
		// el método drawimage utiliza las variables  (imagen a cargar, posición en x, posición en y)
		// el método drawimage se puede usar indistintamente para cargar imágenes jpg, png o svg
	}		
	
}

animacion_con_canvas();
// cuando la página se cargue, ejecutarmos otra función  animacion_con_canvas();
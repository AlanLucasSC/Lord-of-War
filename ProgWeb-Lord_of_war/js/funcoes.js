$(document).ready(function(){
	$('.button').click(function(){
		var text=$('#Text').val();	//Pega valor do campo Text
		//console.log(text);
		$.post("php/bd.php", {text: text}, function(data){
			//console.log(data);
		}, "html");
		$('#Text').val('');	//Retira o valor do campo Text
	});

	$.post("php/bd.php", {pers: 'ok'}, function(data){
		a = $('#pers');
		data = JSON.parse(data);
		//console.log(data);
		tamanho = data.length;
		a.append('<div class="row row-inline">');
		for(i = 0; i < data.length; i++){
			array[i] = data[i].preco;
			a.append(
			`
				<tr class='table-striped'>
				<th scope="row">`+i+`</th>
				<td>`+data[i].nome+`</td>
				<td>`+data[i].vida+`</td>
		    	<td>`+data[i].forca+`</td>
		    	<td>`+data[i].mov+`</td>
		    	<td>`+data[i].preco+`</td>
		      	<td><input onclick="mais(this)" onkeyup="mais(this)" class="form-control is-valid data" min="0" type="number" value="0" id="`+i+`data`+`"></input>
		      	</td>
				<td id="`+i+`">0</td>
			</tr>
			`
			);
		}
		a.append(
			`
				<tr class='table-striped'>
					<th scope="row">#</th>
					<td> </td>
					<td> </td>
			    	<td> </td>
			    	<td> </td>
			    	<td> </td>
			      	<td> <div id='Alerta' class="alert alert-success" role="alert">A compra pode ser efetuada!</div> 
  					</td>
					<td id="Total" class="is-invalid">0</td>
				</tr>
			`
			);
	});
}); 
setInterval(function(){
				a = $('.user');
				$.post("php/bd.php", {mensage: 'ok'}, function(data){
					if (data.length <= 2) {
						//console.log('vazia');
					}
					else{
						//console.log(data);
						//console.log(data.length);
						data = JSON.parse(data);
						for(i = 0; i < data.length; i++){
							//console.log(data[i]);
							var chat = $('.panel-body');

							<?php
								//if ($login == 1) {
									//$a = 'if('.$_SESSION['id'][0]->id.'== data[i].id){';
									//echo $a;
							?>
									chat.append('<h6 class=\"myMensage user\">'+data[i].time+' '+data[i].conta+'</h6><h4 class="myMensage mensage">'+data[i].text+'</h4>');
							<?php
									//echo '}else{';
							?>
									chat.append('<h6 class=\"outerMensage user\">'+data[i].time+' '+data[i].conta+'</h6><h4 class="outerMensage mensage">'+data[i].text+'</h4>');
							<?php
									//echo "}";
								}
								//else {
							?>
								chat.append('<h6 class=\"outerMensage user\">'+data[i].time+' '+data[i].conta+'</h6><h4 class="outerMensage mensage">'+data[i].text+'</h4>');
							<?php
								}
							?>
						} 
					}
				}, "html");    
				//a.append('i');
			}, 1500);
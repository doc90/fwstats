function carica(mese,anno) {
			$.getJSON("data.php?t=0&mese="+mese+"&anno="+anno, function(x){
				if (x.mese.length>0)
					$('#p').html(x.mese+' '+x.anno);
				else
					$('#p').html(x.anno);
			});
			$('#toppost').fadeOut();
			$.getJSON("data.php?t=1&mese="+mese+"&anno="+anno, function(jsonData){
				t='<table id="elenco"><tr><th>Username</th><th>Post scritti</th></tr>';
				$.each(jsonData, function(i, data) {
								t+='<tr><td>'+data.username+'</td><td>'+data.post+'</td></tr>';									
				});
				t+='</table>';
				$('#toppost').html(t);
			});
			$('#toppost').fadeIn();
			$('#topthread').fadeOut();
			$.getJSON("data.php?t=2&mese="+mese+"&anno="+anno, function(jsonData){
				t='<table id="elenco"><tr><th>Username</th><th>Thread aperti</th></tr>';
				$.each(jsonData, function(i, data) {
								t+='<tr><td>'+data.username+'</td><td>'+data.thread+'</td></tr>';									
				});
				t+='</table>';
				$('#topthread').html(t);
			});
			$('#topthread').fadeIn();
			$('#topmipiace').fadeOut();
			try{
				$.getJSON("data.php?t=3&mese="+mese+"&anno="+anno, function(jsonData){
					t='<table id="elenco"><tr><th>Username</th><th>"Mi piace" ricevuti</th></tr>';
					$.each(jsonData, function(i, data) {
									t+='<tr><td>'+data.username+'</td><td>'+data.mipiace+'</td></tr>';									
					});
					t+='</table>';
					$('#topmipiace').html(t);
				});
			}
			catch(e){
				$('#topmipiace').html('<b>Le statistiche "mi piace"<br />sono disponibili a partire da maggio 2013');
				}
			$('#topmipiace').fadeIn();
			$('#topreply').fadeOut();
			$.getJSON("data.php?t=4&mese="+mese+"&anno="+anno, function(jsonData){
				t='<table id="elenco"><tr><th>Username</th><th>Thread</th><th>Reply</th></tr>';
				$.each(jsonData, function(i, data) {
								t+='<tr><td>'+data.username+'</td><td>'+data.title+'</td><td>'+data.reply+'</td></tr>';									
				});
				t+='</table>';
				$('#topreply').html(t);
			});
			$('#topreply').fadeIn();
			$('#topvarie').fadeOut();
			$.getJSON("data.php?t=5&mese="+mese+"&anno="+anno, function(jsonData){
				t='<b>Varie</b><table id="elenco">';
				$.each(jsonData, function(i, data) {
								t+='<tr><td>'+data.desc+'</td><td>'+data.n+'</td></tr>';									
				});
				t+='</table>';
				$('#topvarie').html(t);
			});
			$('#topvarie').fadeIn();
		}
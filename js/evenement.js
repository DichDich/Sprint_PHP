$(document).ready(function(){

    $("#addFiltre").click(function(){
        $("#filtre").fadeToggle();
    });
    $("#addFiltre").click(function(){
        $("#triLangue").fadeToggle();
    });

    $("#Reservation button").click(function(){
    	var thisiD = $(this).attr('id');
        if(thisiD!="occuped")
    	   $("input#plageH").val(thisiD);
    });

    for (var i = 1; i<= $("div#contenu").length; i++) {
        $("span#avis"+i).click(function(){
        	var thisiD = $(this).attr('id');
        	if($("span#"+thisiD).html()==' (+ détail)'){	        	
	            $("p#"+thisiD).fadeIn();
	            $("span#"+thisiD).html(' (- détail)');
        	}else{
        		var thisiD = $(this).attr('id');
	            $("p#"+thisiD).fadeOut();
	            $("span#"+thisiD).html(' (+ détail)');
        	}
        });
    }

    var $opt =  $("#optDetail #Avis");
    $opt.addClass("select");

    $("#optDetail span").hover(function(){
        $("#optDetail span").removeClass();
        $(this).addClass('select');
    },function(){
        $("#optDetail span").removeClass();
        if($opt!=null)
            $opt.addClass('select');
    });

    $("#optDetail #Avis").click(function(){
        $("#optDetail span").removeClass();
        $(this).addClass("select");
        $opt=$(this);
    	$("#element #Photo").removeClass();
    	$("#element #Photo").addClass('hidden');
    	$("#element #Avis").removeClass();
    	$("#element #Avis").addClass('active');
    	$("#element #Reservation").removeClass();
    	$("#element #Reservation").addClass('hidden');
    });
    $("#optDetail #Photo").click(function(){
        $("#optDetail span").removeClass();
        $(this).addClass("select");
        $opt=$(this);
    	$("#element #Photo").removeClass();
    	$("#element #Photo").addClass('active');
    	$("#element #Avis").removeClass();
    	$("#element #Avis").addClass('hidden');
    	$("#element #Reservation").removeClass();
    	$("#element #Reservation").addClass('hidden');
    });
    $("#optDetail #Reservation").click(function(){
        $("#optDetail span").removeClass();
        $(this).addClass("select");
        $opt=$(this);
    	$("#element #Photo").removeClass();
    	$("#element #Photo").addClass('hidden');
    	$("#element #Avis").removeClass();
    	$("#element #Avis").addClass('hidden');
    	$("#element #Reservation").removeClass();
    	$("#element #Reservation").addClass('active');
    });

});

function connexion()
{
    alert("vous êtes connecté");
}
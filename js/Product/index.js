$(document).ready(function()
{
 var limitA = $('#limit a').hide();
 $('#limit').mouseenter(function(){ limitA.slideDown(200);})
            .mouseleave(function(){limitA.slideUp(200);});
 var sortA = $('#productTitle a').hide();
 $('#productTitle').addClass('mainBox')
            .mouseenter(function(){ sortA.slideDown(200);})
            .mouseleave(function(){sortA.slideUp(200);});
});
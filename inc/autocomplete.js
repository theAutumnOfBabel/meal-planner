/* 
 * autocomplete.js
 * ===============
 *
 * This file is responsible for making the Jquery UI autocomplete widget
 * used in new_food.php, new_recipe.php, etc.
 */


/**
 *  populateUnitsMenu()
 *  ===================
 *  Creates options in the passed dropdown menu that have the passed foods
 */
function populateUnitsMenu( menu, food )
{
  menu.append("<option value></option>");
  $.each( food.available_units, function( code, unit )
  {
    if( unit.toLowerCase() === "each" )
    {
      menu.append('<option value="' +
        unit + '">' + unit + "</option>");
    }
    else
    {
      menu.append('<option value="' +
        unit + '">' + unit + '(s)</option>');
    }
  });
}


/*
 *  autocompleteFactory()
 *  =====================
 *
 *  Creates an autocomplete JQuery UI widget on the target.  The file that
 *  will be called to process the Ajax information is procFile.
 *  The name of the GET variable sent to procFile will be ajax_output
 *
 *  @param  - minLength   - the number of characters that must be typed
 *                          before the autocomplete will give
 *                          recommendations
 *
 *  @param  - target      - the CSS selector of the item to become an
 *                          autocomplete (e.g. "#text_input", or ".name")
 *
 *  @param  - procFile    - the path to the file that will process the
 *                          input given by the user.  This file will
 *                          output the autocomplete results.
 */
function autocompleteFactory( minLength, target, procFile )
{
  //set up the category autocomplete widget
  $.widget( "custom.catcomplete", $.ui.autocomplete, {
	  _renderMenu: function( ul, items ) {
	    var that = this,
	    currentCategory = "";
	    $.each( items, function( index, item ) {
		    if ( item.category != currentCategory ) {
		      ul.append( "<li class='ui-autocomplete-category'>" + 
            item.category + "</li>" );
		      currentCategory = item.category;
		    }
		    that._renderItemData( ul, item );
	    });
	  }
  });

  //TODO: make the autocomplete show the matched characters in bold or 
  //underline
  $(target).catcomplete({

	  source: function(request, response){
	    $.ajax({
		    url: procFile,
		    method: "GET",
		    dataType: "json",
		    data: {
			    ajax_output: request.term
		    },
		    success: function( data ){
          displayData = new Array; 
          //TODO: build the array to display and also the hidden
          //one to store the food id

          //take the category and label values from the ajax
          //returned data, and put them into displayData
          $.each( data, function( index, value ){
            displayData.push({ 
              'category'  : value['category'],
              'label'     : value['label']
            });
          });
			    response( displayData );
		    }
	    });
	  },

	  //TODO: eventually make this have the functionality to display a box
    //around the text in the ingredient field if it was selected.
    //clicking that box will delete the food in the entry
	  select:
	    function(e, ui) {
		    var nameOfSelectedFood = ui.item.value;
        var currentIngredientIndex =
          $(this).attr("name").substring(0,1);
        var matchedFood;
        var unitsDropdownMenu = $( "#"+ currentIngredientIndex
            + "_ing_unit" );

        //TODO: find a faster way to do this
        //find the food from the db that matches the selection
        $.each( savedFoods, function( i, savedFood ){
          if( savedFood['user_def_food_name'] === nameOfSelectedFood ){
            matchedFood = savedFood;
          }
        });

        console.log( "matchedFood = %o", matchedFood );

        //remove all existing unit options and replace them with the
        //ones that esha offers for this particular food.
        unitsDropdownMenu.children().remove();
        populateUnitsMenu(unitsDropdownMenu, matchedFood);
	    }//,

    // change:
    //     function(){
    // 	//prevent 'recommendation' field from being updated. Also,
    // 	//correct the position
    // 	$(".recommendation").val("").css("top", 2);
    //     }
  }); //END autocomplete
}

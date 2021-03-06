<?php

//TODO: add constructor for yield and yield_unit

//TODO: make an interface called Edible which contains all the things like 
//cost, calories, name, etc. and make this implement it

//TODO: eventually make it to where the input ingredients should be ingredients 
//objects (implementing the Edible interface).  

//TODO: Make constructor automatically calculate calories and cost.

class Recipe 
{
    protected $name;
    protected $db_id;
    protected $ingredients;
    protected $instructions;
    protected $calories;
    protected $cost;
    protected $user_id; //inherit from edible interface
    protected $yield;
    protected $yield_unit;

    public function __construct( $input )
    {
        if( is_string( $input['ingredients'] ) )
        {
            $this->set_ingredients( json_decode($input['ingredients']) );
        }
        else
        {
            $this->set_ingredients( $input['ingredients'] );
        }

        $this->set_name( $input['name'] );
        $this->set_db_id( $input['db_id'] );
        $this->set_instructions( $input['instructions'] );

        if( isset($input['calories']) )
        {
            $this->set_calories( $input['calories'] );
        }

        if( isset($input['cost']) )
        {
            $this->set_cost( $input['cost'] );
        }

        $this->set_yield( 1, $input['yield_unit'] ); 
        $this->set_user_id( $input['user_id'] ); 
    }


    /**
     * get_ingredient_strings()
     * ========================
     *
     * Returns an array of the recipe's ingredient to_string() output. For 
     * example, this may output an array of the following format:
     *      array(
     *           '1 chopped ingredient_a'
     *           '1 steamed ingredient b'
     *           ...
     *      )
     *
     * @param   - null
     * @returns - $ing_strings      - array of ingredient strings
     */
    public function get_ingredient_strings()
    {
        $ing_strings = array();
        $ings = $this->get_ingredients();

        foreach( $ings as $ing )
        {
            $ing_strings[] = $ing->to_string();
        }

        return $ing_strings;
    }



    public function ingredients_present()
    {
        $ingredients = $this->get_ingredients();
        if( $ingredients == null )
        {
            return false;
        }

        return true;
    }


    /**
     * get_yield_string()
     * ==================
     *
     * Returns a string that contains the yield and the unit.  For 
     * example: '3 meal(s)'
     *
     * @param   - null
     * @return  - a string containing the yield and the unit that the 
     *              yield is denominated in.
     */
    public function get_yield_string() 
    { 
        return $this->yield.' '.$this->yield_unit.'(s)';
    }


    //getter and setter functions
    //calories
    public function get_calories() { 
        if( $this->calories == null )
        {
            //calculate calories based off the ingredients
            $calories = 0;

            foreach( $this->get_ingredients() as $ing )
            {
                $calories += $ing->get_calories();
            }

            $this->calories = $calories;
        }

        return $this->calories;
    }

    public function set_calories( $val = null )
    {
        if( $val == null )
        {
            //calculate calories based off the ingredients
            $calories = 0;

            foreach( $this->get_ingredients() as $ing )
            {
                $calories += $ing->get_calories();
            }

            $this->calories = $calories;
        }
        else
        {
            $this->calories = $val; 
        }
    }



    //cost
    public function get_cost() 
    {
        //TODO: fix this up the way as was done in get_calories
        if( $this->cost == null )
        {
            //calculate cost based off the ingredients
            $cost = 0;

            foreach( $this->get_ingredients() as $ing )
            {
                $cost += $ing->get_cost();
            }

            $this->cost = $cost;
        }
        return $this->cost; 
    }

    public function set_cost( $val = null )
    { 
        if( $val == null )
        {
            if ( !ingredients_present() ) 
            {
                return INSUFFICIENT_DATA;
            }
            
            //calculate cost based off the ingredients
            $cost = 0;

            foreach( $this->get_ingredients() as $ing )
            {
                $cost += $ing->get_cost();
            }

            $this->cost = $cost;
        }
        else
        {
            $this->cost = $val; 
        }
    }

    
    //db_id
    public function get_db_id() { return $this->db_id; }

    public function set_db_id( $new_db_id ) 
    { 
        $this->db_id = $new_db_id; 

        foreach ($this->ingredients as $ingredient) {
            $ingredient->set_recipe_db_id( $this->get_db_id() );
        }
    }

    //name
    public function get_name() { return $this->name; }

    public function set_name( $new_name ) 
    { 
        $this->name = $new_name; 

        foreach ( $this->ingredients as $ingredient ) {
            $ingredient->set_recipe_name( $this->get_name() );
        }
    }


    //ingredients
    public function get_ingredients() { return $this->ingredients; }

    public function set_ingredients( $new_ingredients )
    { 
        $this->ingredients = $new_ingredients;

        foreach ( $this->ingredients as $ingredient ) 
        {
            $ingredient->set_recipe_name( $this->get_name() );
            $ingredient->set_recipe_db_id( $this->get_db_id() );
        }
    }


    //instructions
    public function get_instructions() { return $this->instructions; }

    public function set_instructions( $val )
    { $this->instructions = $val; } 


    //user_id
    public function get_user_id() { return $this->user_id; }
    public function set_user_id( $val ) { $this->user_id = $val; } 


    //yield
    public function get_yield() 
    { 
        return $this->yield;
    }
    public function set_yield( $amt, $units = null )
    { 
        $this->yield = $amt; 

        if( $units )
        {
            $this->yield_unit = $units;
        }
    } 


    //yield_unit
    function get_yield_unit(){
        return $this->yield_unit;
    }
    function set_yield_unit( $val ){
        $this->yield_unit = $val;
    }
    function get_yield_units(){
        return $this->yield_unit;
    }
    function set_yield_units( $val ){
        $this->yield_unit = $val;
    }
}

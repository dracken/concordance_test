<?php
/**
 *  Concordance Test for Untangle
 *  
 *  @author Derek Boerger
 *  @since September 2018
 *  @version 1.0
 *  
 *  Take a string of words with mutliple lines, split the words and count 
 *  how many times the word exists, which line they exist in 
 *  the string and then output all words in alphabetical order
 * 
 */

class concordance
{
    protected $input_string;
    protected $line_split_string = [];
    protected $line_array = [];
    protected $word_count = [];
    protected $words_array = [];
    
    protected $debug_output = "";
    
    public $output = "";
    
    /**
     * 
     * @param string $input_string
     */
    public function __construct(string $input_string)
    {
        $this->run($input_string);
    }
    
    /**
     * 
     * @param string $input_string
     * @return string
     */
    public function run(string $input_string)
    {
        
        // Find all words
        $this->find_words($input_string);
        
        // Divide the sentences
        $this->line_split($input_string);
        
        // Separate the words and process
        $this->line_count($this->line_split_string);

        // Display the results
        $this->display_results($this->words_array);

    }
    
    /**
     * Find words
     * 
     * Uses the built in string word count and returns an array of all words in the input string
     * 
     * @param string $line_split_string
     * @return mixed
     */
    private function find_words(string $line_split_string)
    {
        $words_array = array_unique(array_map('strtolower', str_word_count($line_split_string, 1)));
        natcasesort($words_array);
        
        foreach($words_array as $value)
        {
            $this->words_array[$value] = ["count" => 0, "position" => []];
        }
        
        return true;
    }
    
    /**
     * Line Split
     * 
     * Takes a string with multiple sentences (period and two spaces) and breaks them into seperate arrays
     * 
     * @param string $input_string
     * @return boolean
     */
    private function line_split(string $input_string)
    {
        $input_string = str_replace(array("\r", "\n", "\r\n", "-", "_"), array(".  ", ".  ", ".  ", " ", " "), $input_string);
        $this->line_split_string = explode(".  ", $input_string);
        #$this->line_split_string = preg_split("(?<=\.) {2,}(?=[A-Z]) | [\r\n]", $input_string);
        
        
        return true;
    }
    
    /**
     * Line Count
     * 
     * Iterates through each of the lines returned from line_split and counts each of the words 
     * 
     * @param array $line_split_string
     * @return boolean
     */
    private function line_count(array $line_split_string)
    {
        
        $line_array_count = 0;
        foreach ($line_split_string AS $line_split_array)
        {
            //$line_explode = explode(" ", $line_split_array);
            $line_explode = array_map('strtolower', str_word_count($line_split_array, 1));
            $this->line_array[$line_array_count] = $line_explode; 
            $line_array_count++;
        }
        
        foreach ($this->line_array AS $line => $line_word)
        {
            
            foreach ($line_word AS $word)
            {
                $clean_word = strtolower(preg_replace('/[.,;:\'\"\-\_()]/', '', $word));
                
                if (!isset($this->words_array[$clean_word]) && $clean_word != " ")
                {
                    $this->words_array[$clean_word]["count"] = 0;
                    $this->words_array[$clean_word]["position"] = [];
                }
                $this->words_array[$clean_word]["count"]++;
                $this->words_array[$clean_word]["position"][] = $line + 1;
            }
        }
            
        
        return true;
    }
    
    /**
     * Display Results
     * 
     * 
     * @param array $processed_array
     * @return boolean
     */
    private function display_results(array $processed_array)
    {
        $output_string = "";
        $i = 1;
        foreach($processed_array AS $words_key => $words_value)
        {
            
            $word_count = $words_value["count"];
            $word_lines = implode(", ", $words_value["position"]);
            
            $output_string .= $i.". ".$words_key."\t{".$word_count.": ". $word_lines."}<br />\n";
            $i++;
        }
        
        $this->output = $output_string;
    }
}


?>
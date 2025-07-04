<?php

class Layout_template
{
    private Navbar_template $navbar;

    public function __construct(Navbar_template $navbar)
    {
        $this->navbar = $navbar;
    }


    public function render()
    {
        echo  '
        <!DOCTYPE html>
        <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/x-icon" href="../UI/assets/img/logo.jpg">
        <title>Control</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    </head>
    <body  class="d-flex justify-content-center align-items-center"  style=" background-color: #a8cdee;" >

            ' .
            $this->navbar->render()
            . '

    </body
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        ';
    }
}

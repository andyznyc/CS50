 <?php

    // configuration
    require("../includes/config.php"); 
    
    $rows = query("SELECT symbol, shares FROM portfolio WHERE id = ?", $_SESSION["id"]);
    $money = query("SELECT cash FROM users WHERE id = ?", $_SESSION["id"]);
    
    $usercash = number_format($money[0]["cash"],2);
    
    $positions = [];
    foreach ($rows as $row)
    {   
        $stock = lookup($row["symbol"]);
        if ($stock !== false)
        {
            $positions[] = [
                "name" => $stock["name"],
                "price" => $stock["price"],
                "shares" => $row["shares"],
                "symbol" => $row["symbol"],
                "total" => number_format($row["shares"] * $stock["price"],2)
            ];
        }
    }
    
    
    // render portfolio
    render("portfolio.php", ["positions" => $positions, "title" => "Portfolio", "cash" => $usercash]);

?>

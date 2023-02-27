<?php
function format_price(string $price_str): string
{
  $price = floatval($price_str);
  $formatted_price = number_format($price, 2, ',', ' ');
  return str_replace(',00', '', $formatted_price);
}

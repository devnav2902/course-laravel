<?php
function render_star($ratingAverage)
{
    $render = '';
    $render .= $ratingAverage >= 1 ?
        "<i class='fas fa-star'></i>" : ($ratingAverage >= 0.5 ?
            "<i class='fas fa-star-half'></i>" :
            "<i class='far fa-star'></i>");

    $render .=  $ratingAverage >= 2 ?
        "<i class='fas fa-star'></i>" : ($ratingAverage >= 1.5 ?
            "<i class='fas fa-star-half'></i>" :
            "<i class='far fa-star'></i>");

    $render .=  $ratingAverage >= 3 ?
        "<i class='fas fa-star'></i>" : ($ratingAverage >= 2.5 ?
            "<i class='fas fa-star-half'></i>" :
            "<i class='far fa-star'></i>");

    $render .=  $ratingAverage >= 4 ?
        "<i class='fas fa-star'></i>" : ($ratingAverage >= 3.5 ?
            "<i class='fas fa-star-half'></i>" :
            "<i class='far fa-star'></i>");

    $render .=  $ratingAverage >= 5 ?
        "<i class='fas fa-star'></i>" : ($ratingAverage >= 4.5 ?
            "<i class='fas fa-star-half'></i>" :
            "<i class='far fa-star'></i>");

    return $render;
}

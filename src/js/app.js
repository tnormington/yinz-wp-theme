import "bootstrap"
import "../sass/style.sass"

import "./heroSlider"
import "./masonry"
import "./contributeForm"


console.log("ello world!!!")

const $ = require('jquery')

$(() => {
  $('[data-toggle="tooltip"]').tooltip()
})
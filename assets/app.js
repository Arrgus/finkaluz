/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';

import Chart from 'chart.js/auto';
import {
  tns
} from 'tiny-slider';

if (document.getElementById('periodos-energia-1')) {

  const data = {
    labels: [
      'Red',
      'Blue',
      'Yellow'
    ],
    datasets: [{
      label: 'My First Dataset',
      data: [300, 50, 100],
      backgroundColor: [
        'rgb(255, 99, 132)',
        'rgb(54, 162, 235)',
        'rgb(255, 205, 86)'
      ],
      hoverOffset: 4
    }]
  };

  const config = {
    type: 'doughnut',
    data: data,
  };

  const ctx_periodos_energia_one = document.getElementById('periodos-energia-1').getContext('2d');
  const ctx_periodos_energia_two = document.getElementById('periodos-energia-2').getContext('2d');
  const ctx_periodos_potencia_one = document.getElementById('periodos-potencia-1').getContext('2d');
  const ctx_periodos_potencia_two = document.getElementById('periodos-potencia-2').getContext('2d');

  const periodos_energia_one = new Chart(ctx_periodos_energia_one, config)
  const periodos_energia_two = new Chart(ctx_periodos_energia_two, config)
  const periodos_potencia_one = new Chart(ctx_periodos_potencia_one, config)
  const periodos_potencia_two = new Chart(ctx_periodos_potencia_two, config)
}

if (document.getElementById('clientes-feedback')) {
  var slider = tns({
    container: '#clientes-feedback',
    items: 3,
    slideBy: 'page',
    autoplay: false,
    mouseDrag: true,
    swipeAngle: false,
    speed: 400,
    controls: false,
    nav: false,
  
  });
}
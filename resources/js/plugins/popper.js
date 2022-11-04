import { createPopper } from '@popperjs/core';
const popcorn = document.querySelector('#popcorn');
const tooltip = document.querySelector('#tooltip');

$(function () {
  $('[data-bs-toggle="tooltip"]').tooltip();
})
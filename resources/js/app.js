import "../scss/adminkit.scss";
import "../css/multilevel-menu.css";

import './adminkit';

// Nested Sort
import NestedSort from "nested-sort";
window.NestedSort = NestedSort;

// Notyf JS
import { Notyf } from "notyf";
import '~notyf/notyf.min.css';
window.Notyf = Notyf;

// Sweetalert
import swal from 'sweetalert';
window.swal = swal;

// Tom Select
import TomSelect from "tom-select";
import '~tom-select/dist/css/tom-select.bootstrap5.min.css';
window.TomSelect = TomSelect;
<?php

namespace App\Http\Controllers;

use App\Http\Requests;

class QuotesController extends Controller
{
    public function index() {
        return view('quotes.index');
    }

    public function getCalculation($id) {
        return view('quotes.calculation');
    }

    public function getContract($id) {
        return view('quotes.contract');
    }

    public function getCuttingInfo($id) {
        return view('quotes.cutting');
    }

    public function getDatasheet($id) {
        return view('quotes.datasheet');
    }

    public function getDrawings($id) {
        return view('quotes.drawings');
    }

    public function getGeneralInfo($id) {
        return view('quotes.general');
    }

    public function getMaterials($id) {
        return view('quotes.materials');
    }

    public function getRFQ($id) {
        return view('quotes.rfq');
    }

    public function getTerms($id) {
        return view('quotes.terms');
    }
}

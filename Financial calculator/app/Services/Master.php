<?php

namespace App\Services;

class Master {

	public function getoptions( $arr = [], $value = 'key', $text = 'value', $start = null, $selected = null ) {

		$options = '';

		if($start) {
			$options .= '<option value="">'.$start.'</option>';
		}

		foreach ($arr as $key => $_item) {

			$option_selected = '';
			$option_value = '';

			if($text == 'value') {
				$option_text = $_item;
			} else {
				$option_text = $key;
			}

			if($value) {
				if($value == 'key') {
					$option_value = $key;
				} else {
					$option_value = $_item;
				}
			}

			if($selected) {
				if($selected == $option_value) {
					$option_selected = 'selected="selected"';
				}
			}
			
			$options .= '<option value="'.$option_value.'" '.$option_selected.'>'.$option_text.'</option>';
		}

		return $options;

	}

	public function setformulavalue($data, $indicators, $sings) {		
		
		foreach ($data as $_key => $_item) {
			foreach ($_item as $key => $item) {
				if(isset($item['sign'])) {
					$data[$_key][$key]['value'] = $sings[$item['value']]['sign'];
				}
				if(isset($item['indicator'])) {
					$data[$_key][$key]['value'] = $indicators[$item['value']];
				}
				if(isset($item['f'])) {
					$data[$_key][$key]['value'] = 'Formula '.$item['value'];
				}
			}
		}

		return $data;

	}	

	public function formularesult($formula, $formula_data, $table_data, $year, $periodicity, $period) {

		$result = '';
		$_result = '';
		$sign = '';
		$_sign = '';

		$_formula = $formula_data['formula'][$formula];
		if(isset($formula_data['percent'])) {
			$_percent = in_array($formula, $formula_data['percent']) ? 1 : 0;
		} else {
			$_percent = 0;
		}		

		foreach ($_formula as $key => $item) {
			if(isset($item['indicator'])) {
				if($result == '') {					
					$result = $table_data[$item['value']][$year][$periodicity][$period];
				} else {
					if($sign == 'minus') {
						$result = $result - $table_data[$item['value']][$year][$periodicity][$period];
					}
					if($sign == 'plus') {
						$result = $result + $table_data[$item['value']][$year][$periodicity][$period];
					}
					if($sign == 'split') {
						$result = $result / $table_data[$item['value']][$year][$periodicity][$period];
					}
					if($sign == 'multy') {
						$result = $result * $table_data[$item['value']][$year][$periodicity][$period];
					}
				}
			}
			if(isset($item['sign'])) {
				$sign = $item['value'];
				$_sign = $item['value'];
			}
			if(isset($item['f'])) {
				$_formula = $item['value'];
				$_result = $this->formularesult($_formula, $formula_data, $table_data, $year, $periodicity, $period);
				$sign = $_sign;
				if($result == '') {					
					$result = $_result;					
				} else {
					if($sign == 'minus') {
						$result = $result - $_result;
					}
					if($sign == 'plus') {
						$result = $result + $_result;
					}
					if($sign == 'split') {
						$result = $result / $_result;
					}
					if($sign == 'multy') {
						$result = $result * $_result;
					}
				}
			}
		}

		if($_percent) {
			$result = $result * 100;			
		}

		$result = round($result, 1);

		return $_percent ? $result.'%' : $result;
	}

	public function shorttext($text, $maxcount) {
				
		$count_letters = strlen($text);
		$short_text = substr($text, 0, $maxcount);
		if($maxcount < $count_letters) {
			$short_text .= '...';
		}

		return $short_text;
	}


}
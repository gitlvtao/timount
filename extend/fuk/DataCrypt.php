<?php
/**
 * 数据加/解密.
 * User: fukunari<fukunari@163.com>
 * Date: 2018-10-08
 */

namespace fuk;


class DataCrypt {
	/**
	 * aes加密
	 * @access public
	 * @param array/string $data 待加密数据
	 * @param array $key 加密key(16位)
	 * @param array $iv 向量(16位)
	 * @return string
	 */
	static public function encrypt($data, string $key, $iv = '0000000000000000'): string {
		$cryptString = is_array($data) ? json_encode($data, JSON_ERROR_DEPTH) : $data;

		$cryptString = openssl_encrypt($cryptString, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);

		$cryptString = base64_encode($cryptString);

		return $cryptString;
	}

	/**
	 * aes解密
	 * @access public
	 * @param array $data 待机密数据
	 * @param array $key 加密key(16位)
	 * @param array $iv 向量(16位)
	 * @return string
	 */
	static public function decrypt(string $data, string $key, string $iv = '0000000000000000') {
		$cryptString = base64_decode($data);

		// 考虑到多种开发语言对填充方法的异同性，按位选择多种方式
		$cryptString = openssl_decrypt($cryptString, 'AES-128-CBC', $key, OPENSSL_RAW_DATA | OPENSSL_NO_PADDING, $iv);

		// 直接取json部分
		$regular="/[\{|\[](.+)[\}|\]]/ism";
		if(preg_match_all($regular, $cryptString, $matches)){
			$cryptString =$matches[0][0];
		}else{
			$cryptString = false;
		}

		return $cryptString;
	}
}
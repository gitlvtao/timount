<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2018/12/17
 * Time: 11:45
 */

namespace fuk;
use PHPExcel;

class Excel
{
	public function daoChu($data,$name)
	{
		//导出表格
		$PHPExcel = new \PHPExcel();

		// 设置水平垂直居中
		$PHPExcel->getActiveSheet()->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$PHPExcel->getActiveSheet()->getDefaultStyle()->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);

		/******************************************************************************************************************************************************************************/

		$English = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ','BA','BB','BC','BD','BE','BF'];
		$count = count($name);

		//设置某一列的宽度
//		$PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
//		$PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);

		//设置表头列
//		$PHPExcel->setActiveSheetIndex(0)
//			->setCellValue("A1", "热搜词")
//			->setCellValue("B1", "搜索次数");

//		$inc = 1;
//		foreach ($data as $value){
//			$inc ++;
//			$PHPExcel->getActiveSheet()->setCellValue('A' . $inc, $value['title']);
//			$PHPExcel->getActiveSheet()->setCellValue('B' . $inc, $value['num']);
//		}

		/*改造后*/
		for ($i=0;$i<$count;$i++){
			$PHPExcel->getActiveSheet()->getColumnDimension($English[$i])->setWidth(20);
			$PHPExcel->setActiveSheetIndex(0)->setCellValue($English[$i].'1',$name[$i][0]);
		}
		$inc = 1;
		foreach ($data as $value){
			$inc ++ ;
			for ($i=0;$i<$count;$i++){
				$PHPExcel->getActiveSheet()->setCellValue($English[$i] . $inc, $value[$name[$i][1]]);
			}
		}
		/********************************************************************************************************************************************************************************/

		//重命名表
		$PHPExcel->getActiveSheet()->setTitle('Simple');
		ob_end_clean();//清除缓冲区,避免乱码
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment; filename=" . date("YmdHis") . ".xls");
		header('Cache-Control: max-age=0');
		$objWriter = \PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel2007');
		$objWriter->save("php://output");
		exit();
	}
}
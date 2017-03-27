<?
/**********************************************************************************
Function Name : LIB_StoreUploadImg
Descripion : Use this function to upload image file. This funcion can upload image
			 file maintaining aspect ratio. This function can upload image file of
			 type - gif, jpeg, png and bmp. Stored image could be of type gif, jpeg
			 and png. This function also can add watermarker.


Arguments :
			$post_file_name : name of file-input
			$file_to_copy_path : file path where image will be copied
			$file_to_copy_width : target width of copied file
			$file_to_copy_height : target height of copied file
			$adjust : it can have following values -	
							none : aspect ratio is not preserved. image will be stretched
								   to exactly fit (file_to_copy_width X file_to_copy_height)
							autofit : autofit preserving aspect ratio
									  within (file_to_copy_width X file_to_copy_height)
							widthfit : preserving aspect ratio try fit the image width within
									   file_to_copy_width
							heightfit : preserving aspect ratio try fit the image height within
									    file_to_copy_height
														
			$watermark_gif : if this is specified waermark will be created
			$watermark_position : it can have following values -
								  centre, lefttop, bottomright, righttop, bottomleft

Return Value : On failure return FALSE. This function also return FALSE when user did not
			   select any file for upload.
			   On success return original name of the uploaded file.
***********************************************************************************/

function LIB_StoreUploadImg($post_file_name,$file_to_copy_path,$file_to_copy_width,$file_to_copy_height, $adjust = 'none',
							$watermark_gif = '', $watermark_position = 'centre')
{
	$tmp_file_in_server_path=@$_FILES[$post_file_name]['tmp_name'];
	$tmp_file_in_server_type=strtolower(@$_FILES[$post_file_name]['type']);
	
	if(!$tmp_file_in_server_path) return FALSE;
	
	$tmp_file_in_server=NULL;
	/* Attempt to open */
	switch ($tmp_file_in_server_type)
	{
		case "image/bmp":
			$tmp_file_in_server = 
			@imagecreatefrombmp ($tmp_file_in_server_path);
		break;
		case "image/gif":
			$tmp_file_in_server = 
			@imagecreatefromgif ($tmp_file_in_server_path);
		break;
		case "image/jpg":
		$tmp_file_in_server = 
			@imagecreatefromjpeg ($tmp_file_in_server_path);
		
		case "image/jpeg":
		$tmp_file_in_server = 
			@imagecreatefromjpeg ($tmp_file_in_server_path);
		case "image/pjpeg":
			$tmp_file_in_server = 
			@imagecreatefromjpeg ($tmp_file_in_server_path);
		break;
		case "image/png":
			$tmp_file_in_server = 
			@imagecreatefrompng ($tmp_file_in_server_path);
		break;
	}

	if ($tmp_file_in_server) /* See if it failed */
	{ 

		$tmp_file_in_server_width  = imagesx($tmp_file_in_server);
		$tmp_file_in_server_height = imagesy($tmp_file_in_server);
		
		if(	$file_to_copy_width>0 &&	
			$file_to_copy_height>0 && 
			$tmp_file_in_server_width>0 && 
			$tmp_file_in_server_height>0
		)
		{
			
			
			
			  $width_per=$file_to_copy_width/$tmp_file_in_server_width;
			 $height_per=$file_to_copy_height/$tmp_file_in_server_height;
			
			
			switch($adjust)
			{
				case 'autofit':
					if($width_per<$height_per)
						$height_per=$width_per;
					else
						$width_per=$height_per;
				break;
				case 'widthfit':
					$height_per=$width_per;
				break;
				case 'heightfit':
					$width_per=$height_per;
				break;
				case 'none':
				break;
				default:
			} 
			 $file_to_copy_width=floor($tmp_file_in_server_width*$width_per);
			 $file_to_copy_height=floor($tmp_file_in_server_height*$height_per);
			
			
			if($file_to_copy_width==100 && $file_to_copy_height==100 && $adjust!='autofit')
			  {
			  
			    if($tmp_file_in_server_width < 100 &&  $tmp_file_in_server_height <100)
				  {
				    	 $file_to_copy_width=$tmp_file_in_server_width;
				         $file_to_copy_height=$tmp_file_in_server_height;
				  }
				 else if($tmp_file_in_server_width > 100 &&  $tmp_file_in_server_height < 100) 
				    {
				    	 $file_to_copy_width=$file_to_copy_width;
				         $file_to_copy_height=$tmp_file_in_server_height;
				     }
				else if($tmp_file_in_server_width < 100 &&  $tmp_file_in_server_height > 100) 
				    {
				    	 $file_to_copy_width=$tmp_file_in_server_width;
				         $file_to_copy_height=$file_to_copy_height;
				     }
					
			  }
			
			/*echo 'w='.$file_to_copy_width;
			echo 'h='.$file_to_copy_height;
			
			exit();*/
			if($file_to_copy_width<1)$file_to_copy_width=1;
			if($file_to_copy_height<1)$file_to_copy_height=1;
		}
		else
		{
			@imagedestroy($tmp_file_in_server);
			return FALSE;
		}
			
		$file_to_copy = @imagecreatetruecolor($file_to_copy_width,$file_to_copy_height);
			
		if($file_to_copy)
		{
			imagecopyresampled(	$file_to_copy,$tmp_file_in_server,
								0,0,
								0,0,
								$file_to_copy_width,		$file_to_copy_height,
								$tmp_file_in_server_width,	$tmp_file_in_server_height);
			
			///////////////////////////////////////////////////			
			$watermark = @imagecreatefromgif ($watermark_gif);
			if($watermark)
			{
				$watermark_width = imagesx($watermark);
				$watermark_height = imagesy($watermark);

				switch($watermark_position)
				{
					default:
					case 'centre':
						$watermark_x= floor(($file_to_copy_width-$watermark_width)/2);
						$watermark_y= floor(($file_to_copy_height-$watermark_height)/2);
					break;
					case 'lefttop':
						$watermark_x= 5;
						$watermark_y= 5;
					break;
					case 'bottomright':
						$watermark_x= $file_to_copy_width-$watermark_width-5;
						$watermark_y= $file_to_copy_height-$watermark_height-5;
					break;
					case 'righttop':
						$watermark_x= $file_to_copy_width-$watermark_width-5;
						$watermark_y= 5;
					break;
					case 'bottomleft':
						$watermark_x= 5;
						$watermark_y= $file_to_copy_height-$watermark_height-5;
					break;
				}

				if($watermark_x<0)$watermark_x=0;
				if($watermark_y<0)$watermark_y=0;
			
				@imagecopymerge  (	$file_to_copy  , $watermark  , 
									$watermark_x  , $watermark_y  , 
									0  , 0  , $watermark_width  , $watermark_height  , 
									30  );
			}
			////////////////////////////////////////////////////
			
			
			switch(LIB_GetImgFileExt($file_to_copy_path))
			{
				case "gif":
					imagegif($file_to_copy,$file_to_copy_path);
					@imagedestroy($file_to_copy);
					@imagedestroy($tmp_file_in_server);
					return @$_FILES[$post_file_name]['name']; //return true;
				break;
				case "jpeg":
				case "jpg":
					imagejpeg($file_to_copy,$file_to_copy_path,80);
					@imagedestroy($file_to_copy);
					@imagedestroy($tmp_file_in_server);
					return @$_FILES[$post_file_name]['name']; //return true;
				break;
				case "png":
					imagepng($file_to_copy,$file_to_copy_path,9);
					@imagedestroy($file_to_copy);
					@imagedestroy($tmp_file_in_server);
					return @$_FILES[$post_file_name]['name']; //return true;
				break;
				default:
					@imagedestroy($file_to_copy);
					@imagedestroy($tmp_file_in_server);
					return FALSE;
				break;
			}
			@imagedestroy($file_to_copy);
		}
		@imagedestroy($tmp_file_in_server);
	}
	return FALSE;
}


///////////////////////////////////////////////////////////////////////////////
// Private functions below
///////////////////////////////////////////////////////////////////////////////

function LIB_GetImgFileExt($file_path)
{
	$file_ext=split("\.",$file_path);
	if(count($file_ext)>1)
		$file_ext=$file_ext[count($file_ext)-1];
	else
		$file_ext='';
	return strtolower($file_ext);
}



if(!function_exists('imagecreatefrombmp'))
{
	function imagecreatefrombmp( $filename )
	{
				//Ouverture du fichier en mode binaire
		   if (! $f1 = fopen($filename,"rb")) return FALSE;
		
		 //1 : Chargement des ent?s FICHIER
		   $FILE = unpack("vfile_type/Vfile_size/Vreserved/Vbitmap_offset", fread($f1,14));
		   if ($FILE['file_type'] != 19778) return FALSE;
		
		 //2 : Chargement des ent?s BMP
		   $BMP = unpack('Vheader_size/Vwidth/Vheight/vplanes/vbits_per_pixel'.
						 '/Vcompression/Vsize_bitmap/Vhoriz_resolution'.
						 '/Vvert_resolution/Vcolors_used/Vcolors_important', fread($f1,40));
		   $BMP['colors'] = pow(2,$BMP['bits_per_pixel']);
		   if ($BMP['size_bitmap'] == 0) $BMP['size_bitmap'] = $FILE['file_size'] - $FILE['bitmap_offset'];
		   $BMP['bytes_per_pixel'] = $BMP['bits_per_pixel']/8;
		   $BMP['bytes_per_pixel2'] = ceil($BMP['bytes_per_pixel']);
		   $BMP['decal'] = ($BMP['width']*$BMP['bytes_per_pixel']/4);
		   $BMP['decal'] -= floor($BMP['width']*$BMP['bytes_per_pixel']/4);
		   $BMP['decal'] = 4-(4*$BMP['decal']);
		   if ($BMP['decal'] == 4) $BMP['decal'] = 0;
		
		 //3 : Chargement des couleurs de la palette
		   $PALETTE = array();
		   if ($BMP['colors'] < 16777216)
		   {
			$PALETTE = unpack('V'.$BMP['colors'], fread($f1,$BMP['colors']*4));
		   }
		
		 //4 : Cr?ion de l'image
		   $IMG = fread($f1,$BMP['size_bitmap']);
		   $VIDE = chr(0);
		
		   $res = imagecreatetruecolor($BMP['width'],$BMP['height']);
		   $P = 0;
		   $Y = $BMP['height']-1;
		   while ($Y >= 0)
		   {
			$X=0;
			while ($X < $BMP['width'])
			{
			 if ($BMP['bits_per_pixel'] == 24)
				$COLOR = unpack("V",substr($IMG,$P,3).$VIDE);
			 elseif ($BMP['bits_per_pixel'] == 16)
			 {  
				$COLOR = unpack("n",substr($IMG,$P,2));
				$COLOR[1] = $PALETTE[$COLOR[1]+1];
				/*
				$COLOR = unpack("v",substr($IMG,$P,2));
				$blue  = ($COLOR[1] & 0x001f) << 3;
				$green = ($COLOR[1] & 0x07e0) >> 3;
				$red   = ($COLOR[1] & 0xf800) >> 8;
				$COLOR[1] = $red * 65536 + $green * 256 + $blue;
				*/

			 }
			 elseif ($BMP['bits_per_pixel'] == 8)
			 {  
				$COLOR = unpack("n",$VIDE.substr($IMG,$P,1));
				$COLOR[1] = $PALETTE[$COLOR[1]+1];
			 }
			 elseif ($BMP['bits_per_pixel'] == 4)
			 {
				$COLOR = unpack("n",$VIDE.substr($IMG,floor($P),1));
				if (($P*2)%2 == 0) $COLOR[1] = ($COLOR[1] >> 4) ; else $COLOR[1] = ($COLOR[1] & 0x0F);
				$COLOR[1] = $PALETTE[$COLOR[1]+1];
			 }
			 elseif ($BMP['bits_per_pixel'] == 1)
			 {
				$COLOR = unpack("n",$VIDE.substr($IMG,floor($P),1));
				if     (($P*8)%8 == 0) $COLOR[1] =  $COLOR[1]        >>7;
				elseif (($P*8)%8 == 1) $COLOR[1] = ($COLOR[1] & 0x40)>>6;
				elseif (($P*8)%8 == 2) $COLOR[1] = ($COLOR[1] & 0x20)>>5;
				elseif (($P*8)%8 == 3) $COLOR[1] = ($COLOR[1] & 0x10)>>4;
				elseif (($P*8)%8 == 4) $COLOR[1] = ($COLOR[1] & 0x8)>>3;
				elseif (($P*8)%8 == 5) $COLOR[1] = ($COLOR[1] & 0x4)>>2;
				elseif (($P*8)%8 == 6) $COLOR[1] = ($COLOR[1] & 0x2)>>1;
				elseif (($P*8)%8 == 7) $COLOR[1] = ($COLOR[1] & 0x1);
				$COLOR[1] = $PALETTE[$COLOR[1]+1];
			 }
			 else
				return FALSE;
			 imagesetpixel($res,$X,$Y,$COLOR[1]);
			 $X++;
			 $P += $BMP['bytes_per_pixel'];
			}
			$Y--;
			$P+=$BMP['decal'];
		   }
		
		 //Fermeture du fichier
		   fclose($f1);
		
		 return $res;
	}
	
}
?>
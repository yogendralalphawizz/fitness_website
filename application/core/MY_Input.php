<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Input extends CI_Input {
	public function except($keys, $xss_clean = true){
		$CI =& get_instance();

		$data = $_GET + $_POST;
		unset($data[ $CI->security->get_csrf_token_name() ]);

		$all_keys = array_keys($data);
		$keys_required = array_diff($all_keys, $keys);
		return $this->_fetch_from_array($data, $keys_required, $xss_clean);
	}
	
	public function param($key, $default = '', $xss_clean = true){
		$data = $this->_fetch_from_array($_REQUEST, $key, $xss_clean);
		return ($data ? $data : $default);
	}
	
	public function has($key){
		if( isset( $_REQUEST[ $key ] ) ){
			return true;
		}
		
		return false;
	}
	
	public function is_post(){
		return (strtoupper($this->server('REQUEST_METHOD')) == 'POST');
	}
	
	public function is_method($method){
		return (strtoupper($this->server('REQUEST_METHOD')) == strtoupper($method));
	}
	
	public function upload( $file, $target_dir, array $options = [], $files = false ){
		if( $files === false ){ $files = $_FILES; }
		
		$available = [
			'required' => false,
			'allowed' => [], // mime-types
			'rejected' => [], // mime-types
			'min_size' => 0, // in bytes
			'max_size' => '*', // in bytes
			'filename' => true, // true = auto-generate, false = client-name, string,
			'overwrite' => NULL, // true = yes, false = throw error, NULL = increment
			'min_img_w' => false, // in px
			'min_img_h' => false, // in px
			'max_img_w' => false, // in px
			'max_img_h' => false, // in px
			'thumb_dir' => false, // false or `path to directory`
			'thumb_w' => false, // in px
			'thumb_h' => false, // in px
			'thumb_q' => 100 // 0 - 100
		];
		
		foreach( $available as $key => $value ){
			if( ! isset( $options[$key] ) ){
				$options[$key] = $value;
			}
		}
		
		if(isset($files[ $file ]) &&  $files[ $file ]['error'] == 0) { $FILE_array = $files[ $file ]; }
		elseif($options['required'] == true){
			switch( $files[ $file ]['error'] ){
				case UPLOAD_ERR_INI_SIZE:
					$message = "The uploaded file exceeds the upload_max_filesize directive in php.ini";
					break;
				case UPLOAD_ERR_FORM_SIZE:
					$message = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
					break;
				case UPLOAD_ERR_PARTIAL:
					$message = "The uploaded file was only partially uploaded.";
					break;
				case UPLOAD_ERR_NO_FILE:
					$message = "No file was uploaded.";
					break;
				case UPLOAD_ERR_NO_TMP_DIR:
					$message = "Missing a temporary folder.";
					break;
				case UPLOAD_ERR_CANT_WRITE:
					$message = "Failed to write file to disk.";
					break;
				case UPLOAD_ERR_EXTENSION:
					$message = "File upload stopped by PHP Extension.";
					break;
				default:
					$message = "Unknown error occured while uploading file.";
			}
			
			throw new Exception($message);
		}
		else{ return NULL; } // File is not required.
		
		if($FILE_array['name'] == ''){ throw new Exception('File name is not valid.'); }
		
		$FILE_array['size'] = filesize($FILE_array['tmp_name']);
		
		if( $FILE_array['size'] < $options['min_size'] ){
			throw new Exception('Uploaded File Size was Too Small');
		} else if( $options['max_size'] != '*' && $FILE_array['size'] > $options['max_size'] ){
			throw new Exception('Uploaded File Size was Too Large');
		}

		if( ! extension_loaded('fileinfo') ){
			throw new Exception('Extension `php-fileinfo` is not enabled;.');
		}

		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		if(!$finfo){ throw new Exception('`finfo` Error Occured.'); }
		$file_mime = finfo_file($finfo, $FILE_array['tmp_name']);
		finfo_close($finfo);
		
		if( count( $options['allowed'] ) > 0 ){
            if( ! in_array($file_mime, $options['allowed']) ){
                throw new Exception('File type is not supported.');
            }
		}
		
		if( count( $options['rejected'] ) > 0 ){
            if( in_array($file_mime, $options['rejected']) ){
                throw new Exception('File type is not supported.');
            }
		}
		
		$image_data = false;
		if( function_exists('getimagesize') && $image_data = getimagesize( $FILE_array['tmp_name'] ) ){
			if( $options['min_img_w'] && $options['min_img_w'] > $image_data[0] ){
				throw new Exception('Image width should be higher than '.$options['min_img_w'].'px.');
			} else if( $options['min_img_h'] && $options['min_img_h'] > $image_data[1] ){
				throw new Exception('Image height should be higher than '.$options['min_img_h'].'px.');
			} else if( $options['max_img_w'] && $options['max_img_w'] < $image_data[0] ){
				throw new Exception('Image width should be lower than '.$options['max_img_w'].'px.');
			} else if( $options['max_img_h'] && $options['max_img_h'] < $image_data[1] ){
				throw new Exception('Image height should be lower than '.$options['max_img_h'].'px.');
			}
		}
		
		$target_dir = rtrim($target_dir,'/');
		
		if(!is_dir($target_dir)){
			if( ! @mkdir($target_dir, 0777, true) ){
				throw new Exception('Upload Directory is not available.');
			}
		}
		
		$known = ['ez','aw','atom','atomcat','atomsvc','ccxml','cdmia','cdmic','cdmid','cdmio','cdmiq','cu','davmount','dbk','dssc','xdssc','ecma','emma','epub','exi','pfr','gml','gpx','gxf','stk','ink','inkml','ipfix','jar','ser','class','js','json','jsonml','lostxml','hqx','cpt','mads','mrc','mrcx','ma','nb','mb','mathml','mbox','mscml','metalink','meta4','mets','mods','m21','mp21','mp4s','doc','dot','mxf','bin','dms','lrf','mar','so','dist','distz','pkg','bpk','dump','elc','deploy','oda','opf','ogx','omdoc','onetoc','onetoc2','onetmp','onepkg','oxps','xer','pdf','pgp','asc','sig','prf','p10','p7m','p7c','p7s','p8','ac','cer','crl','pkipath','pki','pls','ai','eps','ps','cww','pskcxml','rdf','rif','rnc','rl','rld','rs','gbr','mft','roa','rsd','rss','rtf','sbml','scq','scs','spq','spp','sdp','setpay','setreg','shf','smi','smil','rq','srx','gram','grxml','sru','ssdl','ssml','tei','teicorpus','tfi','tsd','plb','psb','pvb','tcap','pwn','aso','imp','acu','atc','acutc','air','fcdt','fxp','fxpl','xdp','xfdf','ahead','azf','azs','azw','acc','ami','apk','cii','fti','atx','mpkg','m3u8','swi','iota','aep','mpm','bmi','rep','cdxml','mmd','cdy','cla','rp9','c4g','c4d','c4f','c4p','c4u','c11amc','c11amz','csp','cdbcmsg','cmc','clkx','clkk','clkp','clkt','clkw','wbs','pml','ppd','car','pcurl','dart','rdz','uvf','uvvf','uvd','uvvd','uvt','uvvt','uvx','uvvx','uvz','uvvz','fe_launch','dna','mlp','dpg','dfac','kpxx','ait','svc','geo','mag','nml','esf','msf','qam','slt','ssf','es3','et3','ez2','ez3','fdf','mseed','seed','dataless','gph','ftc','fm','frame','maker','book','fnc','ltf','fsc','oas','oa2','oa3','fg5','bh2','ddd','xdw','xbd','fzs','txd','ggb','ggt','gex','gre','gxt','g2w','g3w','gmx','kml','kmz','gqf','gqs','gac','ghf','gim','grv','gtm','tpl','vcg','hal','zmm','hbci','les','hpgl','hpid','hps','jlt','pcl','pclxl','sfd-hdstx','mpy','afp','listafp','list3820','irm','sc','icc','icm','igl','ivp','ivu','igm','xpw','xpx','i2g','qbo','qfx','rcprofile','irp','xpr','fcs','jam','rms','jisp','joda','ktz','ktr','karbon','chrt','kfo','flw','kon','kpr','kpt','ksp','kwd','kwt','htke','kia','kne','knp','skp','skd','skt','skm','sse','lasxml','lbd','lbe','123','apr','pre','nsf','org','scm','lwp','portpkg','mcd','mc1','cdkey','mwf','mfm','flo','igx','mif','daf','dis','mbk','mqy','msl','plc','txf','mpn','mpc','xul','cil','cab','xls','xlm','xla','xlc','xlt','xlw','xlam','xlsb','xlsm','xltm','eot','chm','ims','lrm','thmx','cat','stl','ppt','pps','pot','ppam','pptm','sldm','ppsm','potm','mpp','mpt','docm','dotm','wps','wks','wcm','wdb','wpl','xps','mseq','mus','msty','taglet','nlu','ntf','nitf','nnd','nns','nnw','ngdat','n-gage','rpst','rpss','edm','edx','ext','odc','otc','odb','odf','odft','odg','otg','odi','oti','odp','otp','ods','ots','odt','odm','ott','oth','xo','dd2','oxt','pptx','sldx','ppsx','potx','xlsx','xltx','docx','dotx','mgp','dp','esa','pdb','pqa','oprc','paw','str','ei6','efif','wg','plf','pbd','box','mgz','qps','ptid','qxd','qxt','qwd','qwt','qxl','qxb','bed','mxl','musicxml','cryptonote','cod','rm','rmvb','link66','st','see','sema','semd','semf','ifm','itp','iif','ipk','twd','twds','mmf','teacher','sdkm','sdkd','dxp','sfs','sdc','sda','sdd','smf','sdw','vor','sgl','smzip','sm','sxc','stc','sxd','std','sxi','sti','sxm','sxw','sxg','stw','sus','susp','svd','sis','sisx','xsm','bdm','xdm','tao','pcap','cap','dmp','tmo','tpt','mxs','tra','ufd','ufdl','utz','umj','unityweb','uoml','vcx','vsd','vst','vss','vsw','vis','vsf','wbxml','wmlc','wmlsc','wtb','nbp','wpd','wqd','stf','xar','xfdl','hvd','hvs','hvp','osf','osfpvg','saf','spf','cmp','zir','zirz','zaz','vxml','wgt','hlp','wsdl','wspolicy','7z','abw','ace','dmg','aab','x32','u32','vox','aam','aas','bcpio','torrent','blb','blorb','bz','bz2','boz','cbr','cba','cbt','cbz','cb7','vcd','cfs','chat','pgn','nsc','cpio','csh','deb','udeb','dgc','dir','dcr','dxr','cst','cct','cxt','w3d','fgd','swa','wad','ncx','dtb','res','dvi','evy','eva','bdf','gsf','psf','pcf','snf','pfa','pfb','pfm','afm','arc','spl','gca','ulx','gnumeric','gramps','gtar','hdf','install','iso','jnlp','latex','lzh','lha','mie','prc','mobi','application','lnk','wmd','wmz','xbap','mdb','obd','crd','clp','exe','dll','com','bat','msi','mvb','m13','m14','wmf','emf','emz','mny','pub','scd','trm','wri','nc','cdf','nzb','p12','pfx','p7b','spc','p7r','rar','ris','sh','shar','swf','xap','sql','sit','sitx','srt','sv4cpio','sv4crc','t3','gam','tar','tcl','tex','tfm','texinfo','texi','obj','ustar','src','der','crt','fig','xlf','xpi','xz','z1','z2','z3','z4','z5','z6','z7','z8','xaml','xdf','xenc','xhtml','xht','xml','xsl','dtd','xop','xpl','xslt','xspf','mxml','xhvml','xvml','xvm','yang','yin','zip','adp','au','snd','mid','midi','kar','rmi','m4a','mp4a','mpga','mp2','mp2a','mp3','m2a','m3a','oga','ogg','spx','opus','s3m','sil','uva','uvva','eol','dra','dts','dtshd','lvp','pya','ecelp4800','ecelp7470','ecelp9600','rip','weba','aac','aif','aiff','aifc','caf','flac','mka','m3u','wax','wma','ram','ra','rmp','wav','xm','cdx','cif','cmdf','cml','csml','xyz','ttc','otf','ttf','woff','woff2','bmp','cgm','g3','gif','ief','jpeg','jpg','jpe','ktx','png','btif','sgi','svg','svgz','tiff','tif','psd','uvi','uvvi','uvg','uvvg','djvu','djv','sub','dwg','dxf','fbs','fpx','fst','mmr','rlc','mdi','wdp','npx','wbmp','xif','webp','3ds','ras','cmx','fh','fhc','fh4','fh5','fh7','ico','sid','pcx','pic','pct','pnm','pbm','pgm','ppm','rgb','tga','xbm','xpm','xwd','eml','mime','igs','iges','msh','mesh','silo','dae','dwf','gdl','gtw','mts','vtu','wrl','vrml','x3db','x3dbz','x3dv','x3dvz','x3d','x3dz','appcache','ics','ifb','css','csv','html','htm','n3','txt','text','conf','def','list','log','in','dsc','rtx','sgml','sgm','tsv','t','tr','roff','man','me','ms','ttl','uri','uris','urls','vcard','curl','dcurl','mcurl','scurl','fly','flx','gv','3dml','spot','jad','wml','wmls','s','asm','c','cc','cxx','cpp','h','hh','dic','f','for','f77','f90','java','nfo','opml','p','pas','etx','sfv','uu','vcs','vcf','3gp','3g2','h261','h263','h264','jpgv','jpm','jpgm','mj2','mjp2','mp4','mp4v','mpg4','mpeg','mpg','mpe','m1v','m2v','ogv','qt','mov','uvh','uvvh','uvm','uvvm','uvp','uvvp','uvs','uvvs','uvv','uvvv','dvb','fvt','mxu','m4u','pyv','uvu','uvvu','viv','webm','f4v','fli','flv','m4v','mkv','mk3d','mks','mng','asf','asx','vob','wm','wmv','wmx','wvx','avi','movie','smv','ice'];
		
		$target_file_ext = [];
		$target_file_name = preg_replace('/[^A-Za-z0-9\.\-\_]/', '', basename( $FILE_array['name'] ) );
		
		$temp = explode('.', $target_file_name);
		for($i = count($temp); $i > 0; $i--){
			if( ! isset( $temp[ $i - 1 ] ) ){
				break;
			}
			
			if( in_array($temp[ $i - 1 ], $known) ){
				array_unshift($target_file_ext, $temp[ $i - 1 ]);
			} else {
				break;
			}
		}
		
		$target_file_ext = implode('.', $target_file_ext);
		
		if( $options['filename'] === true ){
			$options['filename'] = md5( time() . '-' . str_pad( rand(0,999999), 6 , '0', STR_PAD_LEFT ) . '-' . str_pad( rand(0,999999), 6 , '0', STR_PAD_LEFT ) . '-' . str_pad( rand(0,999999), 6 , '0', STR_PAD_LEFT ) );
			$target_file_name = $options['filename'] . '.' . $target_file_ext;
		} else if( $options['filename'] === false ){
			$options['filename'] = substr($target_file_name, 0, strlen($target_file_name) - strlen($target_file_ext));
		} else {
			$target_file_name = $options['filename'] . '.' . $target_file_ext;
		}
		
		$target_path = $target_dir . '/' . $target_file_name;
		
		if( file_exists( $target_path ) ){
			if( $options['overwrite'] === false ){
				throw new Exception('Uploaded file already exists.');
			} else if( $options['overwrite'] === NULL ){
				$i = 0; 
				while( file_exists( $target_path ) ){
					$temp = $options['filename'] . ' ('.$i.')';
					$target_path = $target_dir . '/' . $temp . '.' . $target_file_ext;
					$i++;
				}
				$options['filename'] = $temp;
				$target_file_name = $options['filename'] . '.' . $target_file_ext;
			}
		}
		
		if( ! @move_uploaded_file($FILE_array['tmp_name'], $target_path) ){
			throw new Exception('File Could not be uploaded.');
		}
		
		$thumb_data = false;
		if( $image_data && $options['thumb_dir'] !== false ){
			if( ! extension_loaded('gd') ){
				throw new Exception('Extension `php-gd` is not enabled for creating thumbnail.');
			}

			$options['thumb_dir'] = rtrim($options['thumb_dir'], '/');
			
			$suffix = '';
			if( $options['thumb_dir'] == $target_dir ){
				$suffix = '_thumb';
			}
			
			if( $image_data[2] == IMAGETYPE_JPEG ){
				$thumb_ext = '.jpg';
				$image = imagecreatefromjpeg($target_path);
			} else if( $image_data[2] == IMAGETYPE_PNG ){
				$thumb_ext = '.png';
				$image = imagecreatefrompng($target_path);
			} else if( $image_data[2] == IMAGETYPE_GIF ){
				$thumb_ext = '.gif';
				$image = imagecreatefromgif($target_path);
			} else {
				$image = false;
			}
			
			if( $image ){
				if( $options['thumb_w'] == false ){ $options['thumb_w'] = 200; }
				if( $options['thumb_h'] == false ){
					if($image_data[0] > $image_data[1]) {
						$options['thumb_h'] = floor($options['thumb_w'] / ($image_data[0] / $image_data[1]));
					} else {
						$options['thumb_h'] = $options['thumb_w'];
						$options['thumb_w'] = floor($options['thumb_w'] * ($image_data[0] / $image_data[1]));
					}
				}
				
				$thumb = imagecreatetruecolor($options['thumb_w'], $options['thumb_h']);
				
				if( $image_data[2] == IMAGETYPE_GIF || $image_data[2] == IMAGETYPE_PNG ){
					imagecolortransparent( $thumb, imagecolorallocate($thumb, 0, 0, 0) );
					
					if( $image_data[2] == IMAGETYPE_PNG ){
						imagealphablending($thumb, false);
						imagesavealpha($thumb, true);
					}
				}
				
				imagecopyresampled($thumb, $image, 0, 0, 0, 0, $options['thumb_w'], $options['thumb_h'], $image_data[0], $image_data[1]);
				
				$thumb_target_name = $options['filename'] . $suffix;
				$thumb_target_path = $options['thumb_dir'] . '/' . $thumb_target_name . $thumb_ext;
				if( file_exists( $thumb_target_path ) ){
					$i = 0; 
					while( file_exists( $thumb_target_path ) ){
						$temp = $thumb_target_name . ' ('.$i.')';
						$thumb_target_path = $options['thumb_dir'] . '/' . $temp . $thumb_ext;
						$i++;
					}
					$thumb_target_name = $temp;
				}
				$thumb_target_name = $thumb_target_name . $thumb_ext;
				
				if( $image_data[2] == IMAGETYPE_JPEG ){
					imagejpeg($thumb, $thumb_target_path, $options['thumb_q']);
				} else if( $image_data[2] == IMAGETYPE_PNG ){
					imagepng($thumb, $thumb_target_path, $options['thumb_q']);
				} else if( $image_data[2] == IMAGETYPE_GIF ){
					imagegif($thumb, $thumb_target_path);
				}
				
				$thumb_data = [
					'path' => $thumb_target_path,
					'dir' => $options['thumb_dir'],
					'name' => $thumb_target_name
				];
			}
		}
		
		return array(
			'path' => $target_path,
			'dir' => $target_dir,
			'name' => $target_file_name,
			'orig' => $FILE_array['name'],
			
			'ext' => $target_file_ext,
			'mime'=> $file_mime,
			'size' => $FILE_array['size'],
			'image' => $image_data,
			
			'thumb_path' => ($thumb_data ? $thumb_data['path'] : false),
			'thumb_dir' => ($thumb_data ? $thumb_data['dir'] : false),
			'thumb_name' => ($thumb_data ? $thumb_data['name'] : false)
		);
	}
	
	public function multi_upload( $files, $target_dir, array $options = [], $g_files = false ){
		if( $g_files === false ){ $g_files = $_FILES; }
		
		$available = [
			'required' => false
		];
		
		foreach( $available as $key => $value ){
			if( ! isset( $options[$key] ) ){
				$options[$key] = $value;
			}
		}
		
		$remover_callback = function($uploads){
			foreach($uploads as $upload){
				@unlink( $upload['path'] );
				
				if( $upload['thumb_path'] ){
					@unlink( $upload['thumb_path'] );
				}
			}
		};
		
		if( ! isset( $g_files[$files] ) ){
			if($options['required'] === true){
				throw new Exception('Files were not uploaded to Server.');
			} else { // File is not required.
				return [];
			} 
		} else {
			$FILE_megaArray = $g_files[ $files ];
		}
		
		$uploads = array();
		
		$j = 0;
		foreach($FILE_megaArray['name'] as $i => $name){
			$FILE_single = [
				'file' => [
					'name' => $FILE_megaArray['name'][$i],
					'type' => $FILE_megaArray['type'][$i],
					'tmp_name' => $FILE_megaArray['tmp_name'][$i],
					'error' => $FILE_megaArray['error'][$i],
					'size' => $FILE_megaArray['size'][$i],
				]
			];
			
			try {
				$upload = $this->upload( 'file', $target_dir, $options, $FILE_single );
				if( $upload ){
					$uploads[$i] = $upload;
					$j++;
				}
			} catch (\Exception $e){
				call_user_func($remover_callback, $uploads);
				throw new Exception($FILE_megaArray['name'][$i] . ' : ' . $e->getMessage());
			}
		}
		
		if( is_integer($options['required']) && $j < $options['required'] ){
			call_user_func($remover_callback, $uploads);
			throw new Exception('Atleast '.$options['required'].' Files are Required.');
		}
		
		return $uploads;
	}
}

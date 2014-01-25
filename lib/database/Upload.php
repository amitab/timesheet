<?php
namespace Database;

class Upload {
    
	public $uploadPath;
	public $thumbUploadPath;
	public $mimeTypes = array(
		'jpg' => 'image/jpeg',
	);
	public $arrayName;
	public $maxFileSize;
	public $newFileName = null;
	public $ext;
	public $crop = false;
	public $width;
	public $height;
	
	public function addToMimeTypes($types) {
		foreach ($types as $type) {
			array_push($this->mimeTypes, $type);
		}
	}
	
    public function upload() {
		try {
    
			if (
				!isset($_FILES[$this->arrayName]['error']) ||
				is_array($_FILES[$this->arrayName]['error'])
			) {
				throw new \RuntimeException('Invalid parameters.');
			}
		
			switch ($_FILES[$this->arrayName]['error']) {
				case UPLOAD_ERR_OK:
					break;
				case UPLOAD_ERR_NO_FILE:
					throw new \RuntimeException('No file sent.');
				case UPLOAD_ERR_INI_SIZE:
				case UPLOAD_ERR_FORM_SIZE:
					throw new \RuntimeException('Exceeded filesize limit.');
				default:
					throw new \RuntimeException('Unknown errors.');
			}
		 
			if ($_FILES[$this->arrayName]['size'] > $this->maxFileSize) {
				throw new \RuntimeException('Exceeded filesize limit.');
			}
		
			$finfo = new \finfo(FILEINFO_MIME_TYPE);
			if (false === $this->ext = array_search(
				$finfo->file($_FILES[$this->arrayName]['tmp_name']),
				$this->mimeTypes,
				true
			)) {
				throw new \RuntimeException('Invalid file format.');
			}
			
			$this->newFileName == null ? $this->newFileName = sha1_file($_FILES[$this->arrayName]['tmp_name']) . time() . '.' . $this->ext : 
									$this->newFileName = $this->newFileName . '.' . $this->ext;
			
			if (!move_uploaded_file(
				$_FILES[$this->arrayName]['tmp_name'],
				$this->uploadPath . $this->newFileName
			)) {
				throw new \RuntimeException('Failed to move uploaded file.');
			}
			
			
			if($this->crop) {
				$this->image_resize();
			} 
			
			return $this->newFileName;
			
		} catch (\RuntimeException $e) {
			$GLOBALS['logger']->info($e->getMessage);
			throw new \Exception($e->getMessage());
		}

	}
	
	public function image_resize(){
		try {
			$src = $this->uploadPath . $this->newFileName;
			$dst = $this->thumbUploadPath . 'thumb_' . $this->newFileName;
			
			if(!list($w, $h) = getimagesize($src)) throw new \RuntimeException("Unsupported picture type!");

			if($this->ext == 'jpeg') $this->ext = 'jpg';
			switch($this->ext){
				case 'bmp': $img = imagecreatefromwbmp($src); break;
				case 'gif': $img = imagecreatefromgif($src); break;
				case 'jpg': $img = imagecreatefromjpeg($src); break;
				case 'png': $img = imagecreatefrompng($src); break;
				default : throw new \RuntimeException("Unsupported picture type!");
			}

			// resize
			if($this->crop){
				if($w < $this->width or $h < $this->height) throw new \RuntimeException("Picture is too small!");
				$ratio = max($this->width/$w, $this->height/$h);
				$h = $this->height / $ratio;
				$x = ($w - $this->width / $ratio) / 2;
				$w = $this->width / $ratio;
			}
			else{
				if($w < $this->width and $h < $this->height) throw new \RuntimeException("Picture is too small!");
				$ratio = min($this->width/$w, $this->height/$h);
				$this->width = $w * $ratio;
				$this->height = $h * $ratio;
				$x = 0;
			}

			$new = imagecreatetruecolor($this->width, $this->height);

			// preserve transparency
			if($this->ext == "gif" or $this->ext == "png"){
				imagecolortransparent($new, imagecolorallocatealpha($new, 0, 0, 0, 127));
				imagealphablending($new, false);
				imagesavealpha($new, true);
			}

			imagecopyresampled($new, $img, 0, 0, $x, 0, $this->width, $this->height, $w, $h);

			switch($this->ext){
				case 'bmp': imagewbmp($new, $dst); break;
				case 'gif': imagegif($new, $dst); break;
				case 'jpg': imagejpeg($new, $dst); break;
				case 'png': imagepng($new, $dst); break;
			}
			return true;
		} catch (\RuntimeException $e) {
			$GLOBALS['logger']->info($e->getMessage);
			throw new \Exception($e->getMessage());
		}
	}
	
}


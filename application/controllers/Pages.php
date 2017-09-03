<?php
class Pages extends XSYS_Controller {

    public function view($page = 'home')
    {
            if ( ! file_exists(APPPATH.'views/pages/'.$page.'.php'))
            {
                    // おっと、そのページはありません！
                    show_404();
            }
    
            $data['title'] = ucfirst($page); // 頭文字を大文字に
    
			$this->_fmt_render('pages/'.$page, $data);
    }

}
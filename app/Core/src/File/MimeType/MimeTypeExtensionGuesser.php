<?php

namespace Core\File\MimeType;

class MimeTypeExtensionGuesser implements ExtensionGuesserInterface
{
    /**
     * A map of mime types and their default extensions.
     *
     * @var Array
     */
    protected $defaultExtensions = array(
        'image/bmp'                      => 'bmp',
        'image/x-ms-bmp'                 => 'bmp',
        'image/cgm'                      => 'cgm',
        'image/g3fax'                    => 'g3',
        'image/gif'                      => 'gif',
        'image/ief'                      => 'ief',
        'image/jpeg'                     => 'jpg',
        'image/ktx'                      => 'ktx',
        'image/png'                      => 'png',
        'image/prs.btif'                 => 'btif',
        'image/sgi'                      => 'sgi',
        'image/svg+xml'                  => 'svg',
        'image/tiff'                     => 'tiff',
        'image/vnd.adobe.photoshop'      => 'psd',
        'image/vnd.dece.graphic'         => 'uvi',
        'image/vnd.dvb.subtitle'         => 'sub',
        'image/vnd.djvu'                 => 'djvu',
        'image/vnd.dwg'                  => 'dwg',
        'image/vnd.dxf'                  => 'dxf',
        'image/vnd.fastbidsheet'         => 'fbs',
        'image/vnd.fpx'                  => 'fpx',
        'image/vnd.fst'                  => 'fst',
        'image/vnd.fujixerox.edmics-mmr' => 'mmr',
        'image/vnd.fujixerox.edmics-rlc' => 'rlc',
        'image/vnd.ms-modi'              => 'mdi',
        'image/vnd.ms-photo'             => 'wdp',
        'image/vnd.net-fpx'              => 'npx',
        'image/vnd.wap.wbmp'             => 'wbmp',
        'image/vnd.xiff'                 => 'xif',
        'image/webp'                     => 'webp',
        'image/x-3ds'                    => '3ds',
        'image/x-cmu-raster'             => 'ras',
        'image/x-cmx'                    => 'cmx',
        'image/x-freehand'               => 'fh',
        'image/x-icon'                   => 'ico',
        'image/x-mrsid-image'            => 'sid',
        'image/x-pcx'                    => 'pcx',
        'image/x-pict'                   => 'pic',
        'image/x-portable-anymap'        => 'pnm',
        'image/x-portable-bitmap'        => 'pbm',
        'image/x-portable-graymap'       => 'pgm',
        'image/x-portable-pixmap'        => 'ppm',
        'image/x-rgb'                    => 'rgb',
        'image/x-tga'                    => 'tga',
        'image/x-xbitmap'                => 'xbm',
        'image/x-xpixmap'                => 'xpm',
        'image/x-xwindowdump'            => 'xwd',
    );

    /**
     * {@inheritdoc}
     */
    public function guess($mimeType)
    {
        return isset($this->defaultExtensions[$mimeType]) ? $this->defaultExtensions[$mimeType] : null;
    }
}
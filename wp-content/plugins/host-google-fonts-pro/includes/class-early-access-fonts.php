<?php
defined('ABSPATH') || exit;

/* * * * * * * * * * * * * * * * * * * * * *
 * @author   : Daan van den Bergh
 * @url      : https://ffw.press/
 * @copyright: (c) Daan van den Bergh
 * @license  : GPL2v2 or later
 * * * * * * * * * * * * * * * * * * * * * */

class OmgfPro_EarlyAccessFonts
{
    /**
     * Supported Subsets.
     */
    const EAF_SUBSET_ARABIC     = 'arabic';
    const EAF_SUBSET_ARMENIAN   = 'armenian';
    const EAF_SUBSET_AVESTAN    = 'avestan';
    const EAF_SUBSET_BALINESE   = 'balinese';
    const EAF_SUBSET_BAMUM      = 'bamum';
    const EAF_SUBSET_BATAK      = 'batak';
    const EAF_SUBSET_BENGALI    = 'bengali';
    const EAF_SUBSET_BRAHMI     = 'brahmi';
    const EAF_SUBSET_BUGINESE   = 'buginese';
    const EAF_SUBSET_BUHID      = 'buhid';
    const EAF_SUBSET_CANADIAN_ABORIGINAL = 'canadian-aboriginal';
    const EAF_SUBSET_CARIAN     = 'carian';
    const EAF_SUBSET_CHAM       = 'cham';
    const EAF_SUBSET_CHEROKEE   = 'cherokee';
    const EAF_SUBSET_COPTIC     = 'coptic';
    const EAF_SUBSET_CUNEIFORM  = 'cuneiform';
    const EAF_SUBSET_CYPRIOT    = 'cypriot';
    const EAF_SUBSET_DESERET    = 'deseret';
    const EAF_SUBSET_DEVANAGARI = 'devanagari';
    const EAF_SUBSET_EGYPTIAN_HIEROGLYPHS = 'egyptian-hieroglyphs';
    const EAF_SUBSET_ETHIOPIC   = 'ethiopic';
    const EAF_SUBSET_GEORGIAN   = 'georgian';
    const EAF_SUBSET_GOTHIC     = 'gothic';
    const EAF_SUBSET_GUJARATI   = 'gujarati';
    const EAF_SUBSET_GURMUKHI   = 'gurmuhki';
    const EAF_SUBSET_HANUNOO    = 'hanunoo';
    const EAF_SUBSET_HEBREW     = 'hebrew';
    const EAF_SUBSET_IMPERIAL_ARAMAIC       = 'imperial-aramaic';
    const EAF_SUBSET_INSCRIPTIONAL_PAHLAVI  = 'inscriptional-pahlavi';
    const EAF_SUBSET_INSCRIPTIONAL_PARTHIAN = 'inscriptional-parthian';
    const EAF_SUBSET_JAPANESE   = 'japanese';
    const EAF_SUBSET_JAVANESE   = 'javanese';
    const EAF_SUBSET_KAITHI     = 'kaithi';
    const EAF_SUBSET_KANNADA    = 'kannada';
    const EAF_SUBSET_KAYAH_LI   = 'kayah-li';
    const EAF_SUBSET_KHAROSHTHI = 'kharoshthi';
    const EAF_SUBSET_KHMER      = 'khmer';
    const EAF_SUBSET_KOREAN     = 'korean';
    const EAF_SUBSET_LAO        = 'lao';
    const EAF_SUBSET_LATIN      = 'latin';
    const EAF_SUBSET_LEPCHA     = 'lepcha';
    const EAF_SUBSET_LIMBU      = 'limbu';
    const EAF_SUBSET_LINEAR_B   = 'linear-b';
    const EAF_SUBSET_LISU       = 'lisu';
    const EAF_SUBSET_LYCIAN     = 'lycian';
    const EAF_SUBSET_LYDIAN     = 'lydian';
    const EAF_SUBSET_MALAYALAM  = 'malayalam';
    const EAF_SUBSET_MANDAIC    = 'mandaic';
    const EAF_SUBSET_MEETEI_MAYEK = 'meetei-mayek';
    const EAF_SUBSET_MONGOLIAN    = 'mongolian';
    const EAF_SUBSET_MYANMAR      = 'myanmar';
    const EAF_SUBSET_NEW_TAI_LUE  = 'new-tai-lue';
    const EAF_SUBSET_OGHAM        = 'ogham';
    const EAF_SUBSET_OL_CHIKI     = 'ol-chiki';
    const EAF_SUBSET_OLD_ITALIAN  = 'old-italian';
    const EAF_SUBSET_OLD_PERSIAN  = 'old-persian';
    const EAF_SUBSET_OLD_SOUTH_ARABIAN = 'old-south-arabian';
    const EAF_SUBSET_OLD_TURKIC        = 'old-turkic';
    const EAF_SUBSET_ORIYA             = 'oriya';
    const EAF_SUBSET_OSMANYA    = 'osmanya';
    const EAF_SUBSET_PHAGS_PA   = 'phags-pa';
    const EAF_SUBSET_PHOENICIAN = 'phoenician';
    const EAF_SUBSET_REJANG     = 'rejang';
    const EAF_SUBSET_RUNIC      = 'runic';
    const EAF_SUBSET_SAMARITAN  = 'samaritan';
    const EAF_SUBSET_SAURASHTRA = 'saurashtra';
    const EAF_SUBSET_SHAVIAN    = 'shavian';
    const EAF_SUBSET_SINHALA    = 'sinhala';
    const EAF_SUBSET_SUNDANESE  = 'sundanese';
    const EAF_SUBSET_SYLOTI_NAGRI   = 'syloti-nagri';
    const EAF_SUBSET_SYRIAC_EASTERN = 'syriac-eastern';
    const EAF_SUBSET_SYRIAC_ESTRANGELA = 'syriac-estrangela';
    const EAF_SUBSET_SYRIAC_WESTERN    = 'syriac-western';
    const EAF_SUBSET_TAGALOG    = 'tagalog';
    const EAF_SUBSET_TAGBANWA   = 'tagbanwa';
    const EAF_SUBSET_TAI_LE     = 'tai-le';
    const EAF_SUBSET_TAI_THAM   = 'tai-tham';
    const EAF_SUBSET_TAI_VIET   = 'tai-viet';
    const EAF_SUBSET_TAMIL      = 'tamil';
    const EAF_SUBSET_TELUGU     = 'telugu';
    const EAF_SUBSET_THAANA     = 'thaana';
    const EAF_SUBSET_THAI       = 'thai';
    const EAF_SUBSET_TIBETAN    = 'tibetan';
    const EAF_SUBSET_TIFINAGH   = 'tifenagh';
    const EAF_SUBSET_UGARITIC   = 'ugaritic';
    const EAF_SUBSET_VAI        = 'vai';
    const EAF_SUBSET_YI         = 'yi';


    /**
     * An array of supported Early Access Fonts.
     *
     * Format: 'label' => 'subset'
     *
     * @return string[]
     */
    const SUPPORTED_FONTS = [
        'amstelvaralpha'          => self::EAF_SUBSET_LATIN,
        'cabinvfbeta'             => self::EAF_SUBSET_LATIN,
        'dhyana'                  => self::EAF_SUBSET_LAO,
        'hanna'                   => self::EAF_SUBSET_KOREAN,
        'hannari'                 => self::EAF_SUBSET_JAPANESE,
        'jejugothic'              => self::EAF_SUBSET_KOREAN,
        'jejuhallasan'            => self::EAF_SUBSET_KOREAN,
        'jejumyeongjo'            => self::EAF_SUBSET_KOREAN,
        'karlatamilinclined'      => self::EAF_SUBSET_TAMIL,
        'karlatamilupright'       => self::EAF_SUBSET_TAMIL,
        'khyay'                   => self::EAF_SUBSET_MYANMAR,
        'kokoro'                  => self::EAF_SUBSET_JAPANESE,
        'kopubbatang'             => self::EAF_SUBSET_KOREAN,
        'laomuangdon'             => self::EAF_SUBSET_LAO,
        'laomuangkhong'           => self::EAF_SUBSET_LAO,
        'laosanspro'              => self::EAF_SUBSET_LAO,
        'lohitbengali'            => self::EAF_SUBSET_BENGALI,
        'lohitdevanagari'         => self::EAF_SUBSET_DEVANAGARI,
        'lohittamil'              => self::EAF_SUBSET_TAMIL,
        'myanmarsanspro'          => self::EAF_SUBSET_MYANMAR,
        'nats'                    => self::EAF_SUBSET_TELUGU,
        'nicomoji'                => self::EAF_SUBSET_JAPANESE,
        'nikukyu'                 => self::EAF_SUBSET_JAPANESE,
        'notokufiarabic'          => self::EAF_SUBSET_ARABIC,
        'notonaskharabic'         => self::EAF_SUBSET_ARABIC,
        'notonaskharabicui'       => self::EAF_SUBSET_ARABIC,
        'notonastaliqurdu'        => self::EAF_SUBSET_ARABIC,
        'notonastaliqurdudraft'   => self::EAF_SUBSET_ARABIC,
        'notosansarmenian'        => self::EAF_SUBSET_ARMENIAN,
        'notosansavestan'         => self::EAF_SUBSET_AVESTAN,
        'notosansbalinese'        => self::EAF_SUBSET_BALINESE,
        'notosansbamum'           => self::EAF_SUBSET_BAMUM,
        'notosansbatak'           => self::EAF_SUBSET_BATAK,
        'notosansbengali'         => self::EAF_SUBSET_BENGALI,
        'notosansbengaliui'       => self::EAF_SUBSET_BENGALI,
        'notosansbrahmi'          => self::EAF_SUBSET_BRAHMI,
        'notosansbuginese'        => self::EAF_SUBSET_BUGINESE,
        'notosansbuhid'           => self::EAF_SUBSET_BUHID,
        'notosanscanadianaboriginal' => self::EAF_SUBSET_CANADIAN_ABORIGINAL,
        'notosanscarian'             => self::EAF_SUBSET_CARIAN,
        'notosanscham'               => self::EAF_SUBSET_CHAM,
        'notosanscherokee'           => self::EAF_SUBSET_CHEROKEE,
        'notosanscoptic'             => self::EAF_SUBSET_COPTIC,
        'notosanscuneiform'       => self::EAF_SUBSET_CUNEIFORM,
        'notosanscypriot'         => self::EAF_SUBSET_CYPRIOT,
        'notosansdeseret'         => self::EAF_SUBSET_DESERET,
        'notosansdevanagari'      => self::EAF_SUBSET_DEVANAGARI,
        'notosansdevanagariui'    => self::EAF_SUBSET_DEVANAGARI,
        'notosansegyptianhieroglyphs' => self::EAF_SUBSET_EGYPTIAN_HIEROGLYPHS,
        'notosansethiopic'        => self::EAF_SUBSET_ETHIOPIC,
        'notosansgeorgian'        => self::EAF_SUBSET_GEORGIAN,
        'notosansgothic'          => self::EAF_SUBSET_GOTHIC,
        'notosansgujarati'        => self::EAF_SUBSET_GUJARATI,
        'notosansgujaratiui'      => self::EAF_SUBSET_GUJARATI,
        'notosansgurmukhi'        => self::EAF_SUBSET_GURMUKHI,
        'notosansgurmukhiui'      => self::EAF_SUBSET_GURMUKHI,
        'notosanshanunoo'         => self::EAF_SUBSET_HANUNOO,
        'notosanshebrew'          => self::EAF_SUBSET_HEBREW,
        'notosansimperialaramaic' => self::EAF_SUBSET_IMPERIAL_ARAMAIC,
        'notosansinscriptionalpahlavi'  => self::EAF_SUBSET_INSCRIPTIONAL_PAHLAVI,
        'notosansinscriptionalparthian' => self::EAF_SUBSET_INSCRIPTIONAL_PARTHIAN,
        'notosansjapanese'        => self::EAF_SUBSET_JAPANESE,
        'notosansjavanese'        => self::EAF_SUBSET_JAVANESE,
        'notosanskaithi'          => self::EAF_SUBSET_KAITHI,
        'notosanskannada'         => self::EAF_SUBSET_KANNADA,
        'notosanskannadaui'       => self::EAF_SUBSET_KANNADA,
        'notosanskayahli'         => self::EAF_SUBSET_KAYAH_LI,
        'notosanskharoshthi'      => self::EAF_SUBSET_KHAROSHTHI,
        'notosanskhmer'           => self::EAF_SUBSET_KHMER,
        'notosanskhmerui'         => self::EAF_SUBSET_KHMER,
        'notosanskufiarabic'      => self::EAF_SUBSET_ARABIC,
        'notosanslao'             => self::EAF_SUBSET_LAO,
        'notosanslaoui'           => self::EAF_SUBSET_LAO,
        'notosanslepcha'          => self::EAF_SUBSET_LEPCHA,
        'notosanslimbu'           => self::EAF_SUBSET_LIMBU,
        'notosanslinearb'         => self::EAF_SUBSET_LINEAR_B,
        'notosanslisu'            => self::EAF_SUBSET_LISU,
        'notosanslycian'          => self::EAF_SUBSET_LYCIAN,
        'notosanslydian'          => self::EAF_SUBSET_LYDIAN,
        'notosansmalayalam'       => self::EAF_SUBSET_MALAYALAM,
        'notosansmalayalamui'     => self::EAF_SUBSET_MALAYALAM,
        'notosansmandaic'         => self::EAF_SUBSET_MANDAIC,
        'notosansmeeteimayek'     => self::EAF_SUBSET_MEETEI_MAYEK,
        'notosansmongolian'       => self::EAF_SUBSET_MONGOLIAN,
        'notosansmyanmar'         => self::EAF_SUBSET_MYANMAR,
        'notosansmyanmarui'       => self::EAF_SUBSET_MYANMAR,
        'notosansnewtailue'       => self::EAF_SUBSET_NEW_TAI_LUE,
        'notosansogham'           => self::EAF_SUBSET_OGHAM,
        'notosansolchiki'         => self::EAF_SUBSET_OL_CHIKI,
        'notosansolditalic'       => self::EAF_SUBSET_OLD_ITALIAN,
        'notosansoldpersian'      => self::EAF_SUBSET_OLD_PERSIAN,
        'notosansoldsoutharabian' => self::EAF_SUBSET_OLD_SOUTH_ARABIAN,
        'notosansoldturkic'       => self::EAF_SUBSET_OLD_TURKIC,
        'notosansoriya'           => self::EAF_SUBSET_ORIYA,
        'notosansoriyaui'         => self::EAF_SUBSET_ORIYA,
        'notosansosmanya'         => self::EAF_SUBSET_OSMANYA,
        'notosansphagspa'         => self::EAF_SUBSET_PHAGS_PA,
        'notosansphoenician'      => self::EAF_SUBSET_PHOENICIAN,
        'notosansrejang'          => self::EAF_SUBSET_REJANG,
        'notosansrunic'           => self::EAF_SUBSET_RUNIC,
        'notosanssamaritan'       => self::EAF_SUBSET_SAMARITAN,
        'notosanssaurashtra'      => self::EAF_SUBSET_SAURASHTRA,
        'notosansshavian'         => self::EAF_SUBSET_SHAVIAN,
        'notosanssinhala'         => self::EAF_SUBSET_SINHALA,
        'notosanssundanese'       => self::EAF_SUBSET_SUNDANESE,
        'notosanssylotinagri'     => self::EAF_SUBSET_SYLOTI_NAGRI,
        'notosanssyriaceastern'   => self::EAF_SUBSET_SYRIAC_EASTERN,
        'notosanssyriacestrangela' => self::EAF_SUBSET_SYRIAC_ESTRANGELA,
        'notosanssyriacwestern'   => self::EAF_SUBSET_SYRIAC_WESTERN,
        'notosanstagalog'         => self::EAF_SUBSET_TAGALOG,
        'notosanstagbanwa'        => self::EAF_SUBSET_TAGBANWA,
        'notosanstaile'           => self::EAF_SUBSET_TAI_LE,
        'notosanstaitham'         => self::EAF_SUBSET_TAI_THAM,
        'notosanstaiviet'         => self::EAF_SUBSET_TAI_VIET,
        'notosanstamil'           => self::EAF_SUBSET_TAMIL,
        'notosanstamilui'         => self::EAF_SUBSET_TAMIL,
        'notosanstelugu'          => self::EAF_SUBSET_TELUGU,
        'notosansteluguui'        => self::EAF_SUBSET_TELUGU,
        'notosansthaana'          => self::EAF_SUBSET_THAANA,
        'notosansthai'            => self::EAF_SUBSET_THAI,
        'notosansthaiui'          => self::EAF_SUBSET_THAI,
        'notosanstibetan'         => self::EAF_SUBSET_TIBETAN,
        'notosanstifinagh'        => self::EAF_SUBSET_TIFINAGH,
        'notosansugaritic'        => self::EAF_SUBSET_UGARITIC,
        'notosansvai'             => self::EAF_SUBSET_VAI,
        'notosansyi'              => self::EAF_SUBSET_YI,
        'notoserifarmenian'       => self::EAF_SUBSET_ARMENIAN,
        'notoserifgeorgian'       => self::EAF_SUBSET_GEORGIAN,
        'notoserifkhmer'          => self::EAF_SUBSET_KHMER,
        'notoseriflao'            => self::EAF_SUBSET_LAO,
        'notoserifthai'           => self::EAF_SUBSET_THAI,
        'nunitovfbeta'            => self::EAF_SUBSET_LATIN,
        'opensanshebrew'          => self::EAF_SUBSET_HEBREW,
        'opensanshebrewcondensed' => self::EAF_SUBSET_HEBREW,
        'phetsarath'              => self::EAF_SUBSET_LAO,
        'ponnala'                 => self::EAF_SUBSET_TELUGU,
        'souliyo'                 => self::EAF_SUBSET_LAO,
        'thabit'                  => self::EAF_SUBSET_ARABIC,
        'tharlon'                 => self::EAF_SUBSET_MYANMAR
    ];
}

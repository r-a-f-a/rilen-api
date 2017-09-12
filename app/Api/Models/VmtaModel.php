<?php

namespace Api\Models;

use Illuminate\Database\Eloquent\Model;

class VmtaModel extends Model
{
    protected $connection = 'allin_mailsender';
    protected $table = 'cor_login';
    protected $primaryKey = 'id_login';

    /**
     * @author [Michel Lima] <michel.lima@locaweb.com.br>
     * @since  [2017-08-31]
     * @param  $id
     * @return mixed
     */
    public function getVmtaListByIdAlliN($id)
    {
        $vmta = VmtaModel::where('id_login', '=', $id)
            ->get([
                'vmta',
                'vmta_inativo as vmtaInactive',
                'vmta_inativo2 as vmtaInactive2',
                'vmta_inativo3 as vmtaInactive3',
                'vmta_inativo4 as vmtaInactive4',
                'vmta_prospect as vmtaProspect',
                'vmta_trans as vmtaTrans'
            ]);

        return $vmta;
    }

    public function updateVmta($vmta, $userId)
    {

    }

}

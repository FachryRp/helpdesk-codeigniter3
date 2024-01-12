<!------ Include the above in your HEAD tag ---------->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- <!DOCTYPE html> -->


<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
    @media only screen and (min-width: 768px) {

        .panel-body {
            /* height: 550px; */
            min-height: 32rem;
            max-height: 100%;
            /* max-height: 100%; */
            /* width: 80%; */
            position: relative;
            margin: auto;
            flex-wrap: wrap;
            /* padding: 20px 15px 0; */
            padding: 20px 15px 0;
        }
    }

    @media only screen and (min-width: 768px) {

        .container {
            /* height: 550px; */
            min-height: 32rem;
            max-height: 100%;
            /* max-height: 100%; */
            width: 95%;
            position: relative;
            margin: auto;
            flex-wrap: wrap;
            /* padding: 20px 15px 0; */
            padding: 20px 15px 0;
        }
    }

    .type_msg {
        background-color: rgba(0, 0, 0, 0.3) !important;
        border: 0 !important;
        color: white !important;
        height: 60px !important;
        overflow-y: auto;
    }

    .type_msg:focus {
        box-shadow: none !important;
        outline: 0px !important;
    }

    .send_btn {
        border-radius: 0 15px 15px 0 !important;
        background-color: rgba(0, 0, 0, 0.3) !important;
        border: 0 !important;
        color: white !important;
        cursor: pointer;
    }

    .msg_receive {
        padding-left: 0;
        margin-left: 0;
    }

    .msg_sent {
        padding-bottom: 20px !important;
        margin-right: 0;
    }

    .messages {
        background: white;
        padding: 10px;
        border-radius: 2px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        max-width: 100%;
    }

    .messages>p {
        font-size: 13px;
        margin: 0 0 0.2rem 0;
    }

    .messages>time {
        font-size: 11px;
        color: #ccc;
    }

    .msg_container {
        position: relative;
        padding: 10px;
        overflow: hidden;
        display: flex;
    }

    .received_withd_msg p {
        position: relative;
        background: #e4e8fb none repeat scroll 0 0;
        border-radius: 3px;
        color: #646464;
        font-size: 14px;
        margin: 0;
        padding: 5px 10px 5px 12px;
        width: 100%;
    }

    .time_date {
        position: relative;
        color: #747474;
        display: block;
        font-size: 10px;
        margin: 3px 0 0;
    }

    .received_msg {
        position: relative;
        display: inline-block;
        padding: 0 0 0 10px;
        vertical-align: top;
        width: 92%;
    }

    .received_withd_msg {
        width: 70%;
    }

    .mesgs {
        float: left;
        padding: 40px;
    }

    .sent_msg p {
        position: relative;
        background: #3F51B5 none repeat scroll 0 0;
        border-radius: 3px;
        font-size: 14px;
        margin: 0;
        color: #fff;
        padding: 5px 10px 5px 12px;
        width: 100%;
    }

    .outgoing_msg {
        overflow: hidden;
        margin: 26px 0 26px;
    }

    .sent_msg {
        float: right;
        width: 70%;
        text-align: right;
    }

    .input_msg_write input {
        background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
        border: medium none;
        color: #4c4c4c;
        font-size: 15px;
        min-height: 48px;
        width: 100%;
    }

    /* 
    .panel-footer {} */
</style>
<div class="container">
    <div class="row">
        <div class="row no-gutters">
            <div class="panel panel-primary">
                <br> </br>
                <div class="panel-heading"> Live chat <?php echo $id_ticket ?></div>
                <form method="post" action="<?php echo base_url(); ?>livechat/save">
                    <input name="id_pesan" type="hidden" value="<?php echo $id_ticket; ?>">

                    <div class="chat-body clearfix">
                        <div class="panel-body" id="">
                            <?php $no = 0;
                            foreach ($datachat1 as $row) : $no++; ?>
                                <?php if ($this->session->userdata('id_user') == $row->id_user) {
                                    echo '
                                        <div style="text-align:right;">
                                            <div style="width:80%; display:inline;  background:#ADD8E6; padding: 1rem 1rem; margin: 1rem 1rem 1rem auto ;border-radius: 1.125rem 1.125rem 0 1.125rem; text-align:left;">' . $row->pesan . '</div>
                                            
                                            <p style="margin-top:2rem; font-size: 13px;">' . $row->nama  .  ' <span style="color:#D3D3D3">' . $row->createdat . '</span> </p>
                                        </div>
                                    ';
                                } else {
                                    echo '
                                        <div style="text-align:left;">
                                            <div style="width:80%; display:inline; background:#D3D3D3; padding:1rem 1rem; margin: 1rem; border-radius: 1.125rem 1.125rem 1.125rem 0; min-height: 2.25rem; width: fit-content;">' . $row->pesan . '</div>
                                            <p style="margin-top:2rem;font-size: 13px;">' . $row->nama  . '' . ' <span style="color:#D3D3D3">' . $row->createdat . '</span> </p>
                                        </div>
                                    ';
                                } ?>
                                <br></br>
                            <?php endforeach; ?>
                            <ul class="chatlist">
                                <!-- Pesan-pesan akan ditampilkan disini -->
                        </div>
                    </div>
            </div>
            <div class="panel-footer">
                <div class="input-group">

                    <input type="text" autocomplete="on" placeholder="Type a message" name="pesan" required /><button type="submit" class="btn btn-primary">Send <i class="fa fa-send-o"></i>
                    </button>

                </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- Extends layout --}}
@extends('teams::layout.default')

{{-- Content --}}
@section('content')

    <div class=" container ">

        @if(isset($action_status))

            @if($action_status)
                @php $class = "success"; @endphp
            @else
                @php $class = "danger" @endphp
            @endif
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-custom alert-{{$class}} fade show" role="alert">
                        <div class="alert-icon"><i class="flaticon-warning"></i></div>
                        <div class="alert-text">{{$action_message}}</div>
                        <div class="alert-close">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"><i class="ki ki-close"></i></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

    @endif
    <!--begin::Contacts-->
        <div class="row">


            <!--begin::Aside-->
            <div class="col-md-4">
                <!--begin::Profile Card-->
                <div class="card card-custom card-stretch">
                    <!--begin::Body-->
                    <div class="card-body pt-4">

                        <!--begin::User-->
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-60 symbol-xxl-100 mr-5 align-self-start align-self-xxl-center">
                                <div class="symbol-label" style="background-image:url({{config("app.url").'/'.config("taskmanager.uploads_folder").$team['team_icon']}})"></div>
                            </div>
                            <div>
                                <a href="#" class="font-weight-bolder font-size-h5 text-dark-75 text-hover-primary">
                                    {{$member['first_name'].' '.$member['last_name']}}
                                </a>
                                <div class="text-muted">
                                    {{$member['created_at']}}
                                </div>
{{--                                <div class="mt-2">--}}
{{--                                    <a href="#" data-toggle="modal" data-backdrop="false" class="btn btn-sm btn-success font-weight-bold mr-2 py-2 px-3 px-xxl-5 my-1">Online</a>--}}
{{--                                </div>--}}
                            </div>
                        </div>
                        <!--end::User-->

                        <!--begin::Contact-->
                        <div class="py-9">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-muted text-hover-primary"></span>
                            </div>
                        </div>
                        <!--end::Contact-->
                        <!--begin::Nav-->
                        <div class="navi navi-bold navi-hover navi-active navi-link-rounded gutter-t">
                            @include("teams::pages.team.team_member_vertical")
                        </div>
                        <!--end::Nav-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Profile Card-->
            </div>
            <!--end::Aside-->
            <!--begin::Content-->
            <div class="col-md-8 " id="kt_chat_content" >

                <div id="read-chats" class="card card-custom card-stretch" style="display: none;">
                    <!--begin::Header-->
                    <div class="card-header align-items-center px-4 py-3">
                        <div class="text-left flex-grow-1">
                            <!--begin::Aside Mobile Toggle-->
                            <button type="button" class="btn btn-clean btn-sm btn-icon btn-icon-md d-lg-none" id="kt_app_chat_toggle">
                        <span class="svg-icon svg-icon-lg"><!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Adress-book2.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"></rect>
                                    <path d="M18,2 L20,2 C21.6568542,2 23,3.34314575 23,5 L23,19 C23,20.6568542 21.6568542,22 20,22 L18,22 L18,2 Z" fill="#000000" opacity="0.3"></path>
                                    <path d="M5,2 L17,2 C18.6568542,2 20,3.34314575 20,5 L20,19 C20,20.6568542 18.6568542,22 17,22 L5,22 C4.44771525,22 4,21.5522847 4,21 L4,3 C4,2.44771525 4.44771525,2 5,2 Z M12,11 C13.1045695,11 14,10.1045695 14,9 C14,7.8954305 13.1045695,7 12,7 C10.8954305,7 10,7.8954305 10,9 C10,10.1045695 10.8954305,11 12,11 Z M7.00036205,16.4995035 C6.98863236,16.6619875 7.26484009,17 7.4041679,17 C11.463736,17 14.5228466,17 16.5815,17 C16.9988413,17 17.0053266,16.6221713 16.9988413,16.5 C16.8360465,13.4332455 14.6506758,12 11.9907452,12 C9.36772908,12 7.21569918,13.5165724 7.00036205,16.4995035 Z" fill="#000000"></path>
                                </g>
                            </svg><!--end::Svg Icon-->
                        </span>
                            </button>
                            <!--end::Aside Mobile Toggle-->
                        </div>
                        <div class="text-center text-center">
                            <div class="symbol-group symbol-hover justify-content-center">
                                <h3 class="card-title"><b>{{$member['first_name'].' '.$member['last_name']}} </b> </h3>
                            </div>
                        </div>

                    </div>
                    <!--end::Header-->

                    <!--begin::Body-->
                    <div class="card-body">
                        <!--begin::Scroll-->
                        <div id="messages" class="messages scroll scroll-pull" style="height: 344px; overflow-y: scroll;"  data-mobile-height="350" >
                            <!--begin::Messages-->
                        </div>
                    </div>
                    <!--end::Body-->
                    <div id="loadingProgressG" class="hidden">
                        <div id="loadingProgressG_1" class="loadingProgressG"></div>
                    </div>
                    <!--begin::Footer-->
                    <span class="text-muted" style="padding-left: 10px" id="typingState"></span>
                    <div class="card-footer align-items-center">
                        <!--begin::Compose-->
                        <textarea onkeydown="sendTypingStatus()" onkeyup="removeTypingStatus()" id="message" class="form-control border-0 p-0" rows="2" placeholder="Type a message"></textarea>
                        <div class="d-flex align-items-center justify-content-between mt-5">
                            <div class="mr-3">
                                <input type="file" id="imageInput"  onchange="sendFIle()" />
                                <a href="#" class="btn btn-clean btn-icon btn-md mr-1" id="imageSelector">
                                    <i class="flaticon2-files-and-folders icon-lg"></i>
                                </a>
                            </div>
                            <div>
                                <button onclick="sendMessage()" type="button" class="btn btn-primary btn-md text-uppercase font-weight-bold chat-send py-2 px-6">Send</button>
                            </div>
                        </div>
                        <!--begin::Compose-->
                    </div>
                    <!--end::Footer-->
                </div>

                <div id="firebase-login" style="display: none">
                    <div class="card card-custom bg-light gutter-b">
                        <!--begin::Header-->
                        <div class="card-header border-0">
                            <h3 class="card-title font-weight-bold text-danger">You are OFFLINE, please provide your details to be online</h3>
                        </div>
                        <!--end::Header-->

                        <!--begin::Body-->
                        <div class="card-body pt-2">
                            <!--begin::Form-->
                            <div class="form-group">
                                <input id="attempt-login-email" value="{{$user->email}}" readonly type="text" class="form-control border-0" name="email" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <input id="attempt-login-password" type="password" class="form-control border-0" name="name" placeholder="Password">
                            </div>
                            <div class="mt-10">
                                <button onclick="attemptLogin()" class="btn btn-primary font-weight-bold">Submit</button>
                            </div>

                            <!--end::Form-->
                        </div>
                        <!--end::Body-->
                    </div>
                </div>

                <div id="firebase-register" style="display: none">
                    <div class="card card-custom bg-light gutter-b">
                        <!--begin::Header-->
                        <div class="card-header border-0">
                            <h3 class="card-title font-weight-bold text-danger">You are OFFLINE, please provide your details to be online</h3>
                        </div>
                        <!--end::Header-->

                        <!--begin::Body-->
                        <div class="card-body pt-2">
                            <!--begin::Form-->
                            <div class="form-group">
                                <input id="re-attempt-login-email" value="{{$user->email}}" readonly type="text" class="form-control border-0" name="email" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <input id="re-attempt-login-password" type="password" class="form-control border-0" name="name" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <input id="re-attempt-login-re-password" type="password" class="form-control border-0" name="name" placeholder="Confirm Password">
                            </div>
                            <div class="mt-10">
                                <button onclick="attemptRegister()" class="btn btn-primary font-weight-bold">Submit</button>
                            </div>

                            <!--end::Form-->
                        </div>
                        <!--end::Body-->
                    </div>
                </div>

            </div>
            <!--end::Content-->
        </div>
        <!--end::Contacts-->
    </div>
@endsection

{{-- Scripts Section --}}
@section('scripts')
    <script>

        $(function(){
            // Get the input field
            let input = document.getElementById("message");

            input.addEventListener("keydown", ({key}) => {
                //key.preventDefault();

                if (key.shiftKey) {
                    alert("");
                }


                if (key === "Enter") {
                    sendMessage()
                }

            });

        })

        firebaseApp.auth().onAuthStateChanged(function(user) {
            if (user) {
                if(user.email != "{{$user->email}}"){
                    attemptLogout();
                }
                userData = user;
                promptLogin =  false;
                localFunctions()
            } else {
                promptLogin = true;
                displayLogin();
            }
        });

        function localFunctions(){
            readChats();
            getTypingState();
        }

        function sendMessage(){

            $( function(){

                let message = $('textarea#message');

                if(message.val().trim().length === 0)
                    return;
                let text = message.val().trim();
                message.val("");
                postMessage(text);
            });

        }

        function addMessage(message){

            let dir = "end";
            let col = "bg-light-primary";

            if(message.from == "member_{{$user->id}}"){

                dir = "end";
                col = "bg-light-primary";

            } else {

                dir = "start";
                col = "bg-light-info";
            }

            $( function(){

                let container = $('div.messages');

                let content = "<!--begin::Message Out-->\n" +
                    "                                <div class=\"d-flex flex-column mb-5 align-items-"+dir+"\">\n" +
                    "                                    <div class=\"d-flex align-items-center\">\n" +
                    "                                        <div>\n" +
                    "                                            <span class=\"text-muted font-size-sm\">"+moment(Number(message.date)).fromNow()+"</span>\n" +
                    "                                        </div>\n"+
                    "                                    </div>\n" +
                    "                                    <div class=\"mt-2 rounded p-5  text-dark-50 font-weight-bold font-size-lg text-right max-w-400px "+col+"\">\n" + message.message +
                    "                                    </div>\n" +
                    "                                </div>\n" +
                    "                                <!--end::Message Out-->";

                if(message.type == "file"){

                    let images = ["png", "jpg", "btm", "gif","web"];
                    if(images.includes(message.fileExt)){
                        content = "<!--begin::Message Out-->\n" +
                            "                                <div class=\"d-flex flex-column mb-5 align-items-"+dir+"\">\n" +
                            "                                    <div class=\"d-flex align-items-center\">\n" +
                            "                                        <div>\n" +
                            "                                            <span class=\"text-muted font-size-sm\">"+moment(Number(message.date)).fromNow()+"</span>\n" +
                            "                                        </div>\n"+
                            "                                    </div>\n" +
                            "                                    <a target='_blank'  href='" + message.fileUrl + "' ><img src=" + message.fileUrl + " class=\"mt-2 rounded p-5  text-dark-50 font-weight-bold font-size-lg text-right max-w-400px "+col+"\"></a>\n" +
                            "                                </div>\n" +
                            "                                <!--end::Message Out-->";
                    }else{
                        content = "<!--begin::Message Out-->\n" +
                            "                                <div class=\"d-flex flex-column mb-5 align-items-"+dir+"\">\n" +
                            "                                    <div class=\"d-flex align-items-center\">\n" +
                            "                                        <div>\n" +
                            "                                            <span class=\"text-muted font-size-sm\">"+moment(Number(message.date)).fromNow()+"</span>\n" +
                            "                                        </div>\n"+
                            "                                    </div>\n" +
                            "                                    <a style='padding: 5px; border: 1px grey solid' download='' target='_blank' href='" + message.fileUrl + "' >"+message.fileName+"</a>\n" +
                            "                                </div>\n" +
                            "                                <!--end::Message Out-->";
                    }


                }




                container.append(content);

                let objDiv = document.getElementById("messages");
                objDiv.scrollTop = objDiv.scrollHeight;
            })
        }

        function addMessageOut(message){
            $( function(){
                let container = $('div.messages');
                let content = "<!--begin::Message Out-->\n" +
                    "                                <div class=\"d-flex flex-column mb-5 align-items-end\">\n" +
                    "                                    <div class=\"d-flex align-items-center\">\n" +
                    "                                        <div>\n" +
                    "                                            <span class=\"text-muted font-size-sm\">"+moment(Number(message.date)).fromNow()+"</span>\n" +
                    "                                        </div>\n"+
                    "                                    </div>\n" +
                    "                                    <div class=\"mt-2 rounded p-5 bg-light-primary text-dark-50 font-weight-bold font-size-lg text-right max-w-400px\">\n" + message.message +
                    "                                    </div>\n" +
                    "                                </div>\n" +
                    "                                <!--end::Message Out-->";
                container.append(content);

                let objDiv = document.getElementById("messages");
                objDiv.scrollTop = objDiv.scrollHeight;
            })
        }

        function addMessageIn(message){
            let container = $('div.messages');
            let content = " <!--begin::Message In-->\n" +
                "                                <div class=\"d-flex flex-column mb-5 align-items-start\">\n" +
                "                                    <div class=\"d-flex align-items-center\">\n" +
                "                                        <div>\n" +
                "                                            <span class=\"text-muted font-size-sm\">"+moment(Number(message.date)).fromNow()+"</span>\n" +
                "                                        </div>\n" +
                "                                    </div>\n" +
                "                                    <div class=\"mt-2 rounded p-5 bg-light-success text-dark-50 font-weight-bold font-size-lg text-left max-w-400px\">\n" + message.message+
                "                                    </div>\n" +
                "                                </div>\n" +
                "                                <!--end::Message In-->";
            container.append(content);

            let objDiv = document.getElementById("messages");
            objDiv.scrollTop = objDiv.scrollHeight;

        }

        function postMessage(message){

            let currentDate = new Date().getTime().toString();

            let ref = firebaseDatabase.ref("member_chats/member_{{$user->id}}/member_{{$member->id}}");

            let key = ref.push().getKey();

            ref.child(key).set({
                team:"{{$team['id']}}",
                name:"{{$user->name}}",
                message: message,
                seen: true,
                delivered: true,
                to: "member_{{$member->id}}",
                from: "member_{{$user->id}}",
                type: "text",
                date: currentDate,
            });

            let ref2 = firebaseDatabase.ref("member_chats/member_{{$member->id}}/member_{{$user->id}}");

            ref2.child(key).set({
                team:"{{$team['id']}}",
                name:"{{$user->name}}",
                message: message,
                seen: false,
                delivered: false,
                to: "member_{{$member->id}}",
                from: "member_{{$user->id}}",
                type: "text",
                date: currentDate,
            });

        }

        function displayLogin(){
            let form = $('div#firebase-login');
            let chats = $('div#read-chats');
            chats.hide();
            form.show();
        }

        function hideLogin(){
            let form = $('div#firebase-login');
            let form2 = $('div#firebase-register');
            form2.hide();
            let chats = $('div#read-chats');
            chats.show();
            form.hide();
        }

        function readChats(){


            if(promptLogin == true)
            {
                displayLogin()
                return;
            }

            hideLogin();

            let ref = firebaseDatabase.ref("member_chats/member_{{$member->id}}/member_{{$user->id}}");

            ref.on('child_added', function (snapshot){

                addMessage(snapshot.val());

            })
        }

        function getTypingState(){

            firebaseDatabase.ref("TypingState/member_{{$member->id}}/member_{{$user->id}}")
                .on("value", function (snapshot) {
                    var typingState = document.getElementById(
                        "typingState"
                    );
                    if(snapshot.val() != null){
                        typingState.innerHTML =
                            snapshot.val().typingState == "typing..."
                                ? "is typing..." : "";
                    }

                });
        }

        function sendTypingStatus(){
            firebaseDatabase.ref("TypingState/member_{{$user->id}}/member_{{$member->id}}").update({
                typingState: 'typing...'
            })
        }

        function updateTypingStatus(){
            setTimeout(function(){
                firebaseDatabase.ref("TypingState/member_{{$user->id}}/member_{{$member->id}}").update({
                    typingState: 'typing...'
                })
            }, 2000).then(() => {
                firebaseDatabase.ref("TypingState/member_{{$user->id}}/member_{{$member->id}}").update({
                    typingState: ''
                })
            }).catch(() => {
                firebaseDatabase.ref("TypingState/member_{{$user->id}}/member_{{$member->id}}").update({
                    typingState: ''
                })
            });
        }

        function removeTypingStatus(){

            setTimeout(function(){
                firebaseDatabase.ref("TypingState/member_{{$user->id}}/member_{{$member->id}}").update({
                    typingState: ''
                })
            }, 5000);
        }

    </script>

    <script>
        function openImageModal(source){
            let image = document.getElementById('imgToShow')
            image.src = source;
            $('#imgModal').modal('show')
        }
    </script>
    <style>
        #chat-messages {
            overflow: scroll;
            height: 450px;
        }

        .hidden{
            display: none;
        }

        #imageInput{
            display: none;
        }

        #loadingProgressG{
            width:100%;
            height:3px;
            overflow:hidden;
            background-color:rgb(0,0,0);
            margin:auto;
            border-radius:3px;
            -o-border-radius:3px;
            -ms-border-radius:3px;
            -webkit-border-radius:3px;
            -moz-border-radius:3px;
        }

        .loadingProgressG{
            background-color:rgb(255,255,255);
            margin-top:0;
            margin-left:-90px;
            animation-name:bounce_loadingProgressG;
            -o-animation-name:bounce_loadingProgressG;
            -ms-animation-name:bounce_loadingProgressG;
            -webkit-animation-name:bounce_loadingProgressG;
            -moz-animation-name:bounce_loadingProgressG;
            animation-duration:1s;
            -o-animation-duration:1s;
            -ms-animation-duration:1s;
            -webkit-animation-duration:1s;
            -moz-animation-duration:1s;
            animation-iteration-count:infinite;
            -o-animation-iteration-count:infinite;
            -ms-animation-iteration-count:infinite;
            -webkit-animation-iteration-count:infinite;
            -moz-animation-iteration-count:infinite;
            animation-timing-function:linear;
            -o-animation-timing-function:linear;
            -ms-animation-timing-function:linear;
            -webkit-animation-timing-function:linear;
            -moz-animation-timing-function:linear;
            width:90px;
            height:7px;
        }

        @keyframes bounce_loadingProgressG{
            0%{
                margin-left:-90px;
            }

            100%{
                margin-left:90px;
            }
        }

        @-o-keyframes bounce_loadingProgressG{
            0%{
                margin-left:-90px;
            }

            100%{
                margin-left:90px;
            }
        }

        @-ms-keyframes bounce_loadingProgressG{
            0%{
                margin-left:-90px;
            }

            100%{
                margin-left:90px;
            }
        }

        @-webkit-keyframes bounce_loadingProgressG{
            0%{
                margin-left:-90px;
            }

            100%{
                margin-left:90px;
            }
        }

        @-moz-keyframes bounce_loadingProgressG{
            0%{
                margin-left:-90px;
            }

            100%{
                margin-left:90px;
            }
        }

    </style>

    <script>
        var enterPressed = function() {
            $('#message').keyup(function(event) {
                if(event.which == 13) {
                    sendMessage();
                }
            });
        };

        enterPressed();
    </script>

    <script>
        var imgBtn = document.getElementById('imageSelector');
        var fileInp = document.getElementById('imageInput');

        imgBtn.addEventListener('click', function() {
            fileInp.click();
        })

        function sendFIle(){
            let loadingIndicator = document.getElementById('loadingProgressG');
            loadingIndicator.classList.remove('hidden');

            let imageFile = new FormData();
            imageFile.append('file', document.getElementById('imageInput').files[0]);

            if(imageFile == null){
                console.log('image does not exist');
                return;
            }

            axios.post(URL + '/send-file', imageFile).then((res) => {

                let filePath = JSON.parse(JSON.stringify(res.data.filePath));
                let fileExt = JSON.parse(JSON.stringify(res.data.fileExt));
                let fileName = JSON.parse(JSON.stringify(res.data.fileName));
                let recieverToken;
                let avatarUrl;
                let name;

                let config = {
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'key=AAAAl1NrEXs:APA91bHKnVkbGrNHDhp5_rXyCuTChvA0tP1kAnjnr03lRneVa2--FEaNL-oG8wCNV_faLcq1jsfSdoVZ-0s5DSBBuAPDI-9hOSs2UZSSAp77UMruzmA6Eg1Dxv58bTVCNzpJtkzGsMuA'
                    }
                }

                let currentDate = new Date().getTime().toString();

                let ref = firebaseDatabase.ref("member_chats/member_{{$user->id}}/member_{{$member->id}}");

                let key = ref.push().getKey();

                ref.child(key).set({
                    fileExt: fileExt,
                    fileUrl: filePath,
                    fileName: fileName,
                    team:"{{$team['id']}}",
                    name:"{{$user->name}}",
                    message: "",
                    seen: true,
                    delivered: true,
                    to: "member_{{$member->id}}",
                    from: "member_{{$user->id}}",
                    type: "file",
                    date: currentDate,
                });

                let ref2 = firebaseDatabase.ref("member_chats/member_{{$member->id}}/member_{{$user->id}}");

                ref2.child(key).set({
                    fileExt: fileExt,
                    fileUrl: filePath,
                    fileName: fileName,
                    team:"{{$team['id']}}",
                    name:"{{$user->name}}",
                    message: "",
                    seen: false,
                    delivered: false,
                    to: "member_{{$member->id}}",
                    from: "member_{{$user->id}}",
                    type: "file",
                    date: currentDate,
                });

                let data = {
                    "to": recieverToken,
                    "data": {
                        "sender": this.currentUserId,
                        "title": name,
                        "imageUrl": filePath,
                        "body": "",
                        "receiver": this.recieverId,
                        "category": "chats",
                        "bigBody": "",
                        "messageKey": key,
                        "token": recieverToken,
                        "senderImageUrl": avatarUrl
                    }
                }

                axios.post('https://fcm.googleapis.com/fcm/send', data, config);

                loadingIndicator.classList.add('hidden');

                document.getElementById('imageInput').value = null;
            }).catch((error) => {
                alert(error);
                loadingIndicator.removeClass("hidden");
                loadingIndicator.classList.add('hidden');
                console.log(error);
                document.getElementById('imageInput').value = null;

            });
        }
    </script>


@endsection

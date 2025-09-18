$(document).ready(function(){
    $('#register-form').submit(function(e){
        e.preventDefault();

        full_name=$('#full_name').val();
        email=$('#email').val();
        password=$('#password').val();
        country=$('#country').val();
        city=$('#city').val();
        contact=$('#contact').val();
        role=$('input[name="role"]:checked').val()||2;

        if(full_name==''||email==''||password==''||country==''||city==''||contact==''){
            Swal.fire({icon:'error',title:'Oops...',text:'Please fill in all fields!'});
            return;
        }else if(password.length<8){
            Swal.fire({icon:'error',title:'Oops...',text:'Password must be at least 8 characters long'});
            return;
        }

        $.ajax({
            url:'../actions/register_user_action.php',
            type:'POST',
            data:{
                full_name:full_name,
                email:email,
                password:password,
                country:country,
                city:city,
                contact:contact,
                role:role
            },
            success:function(response){
                if(response.status==='success'){
                    Swal.fire({icon:'success',title:'Success',text:response.message})
                    .then((result)=>{
                        if(result.isConfirmed&&response.redirect){
                            window.location.href=response.redirect;
                        }
                    });
                }else{
                    Swal.fire({icon:'error',title:'Oops...',text:response.message});
                }
            },
            error:function(){
                Swal.fire({icon:'error',title:'Oops...',text:'An error occurred! Please try again later.'});
            }
        });
    });
});
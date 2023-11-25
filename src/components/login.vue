<template>
  <div id="login">
    <h1>Connexion</h1>
    <input type="mail" v-model="mail" placeholder="Entrez votre adresse email">
    <br>
    <input type="password" v-model="password" placeholder="Entrez votre mot de passe">
    <br>
    <button @click="login">Se connecter</button>
    <br>
    <p id="forgot-password-link">Mot de passe oublié</p>
    <br>
    <p id="register-link">s'inscrire</p>
  
  </div>

</template>
<script>
import axios from "axios";
 


export default {
  name: "login",
  data() {
    return {
      mail: '',
      password: '',
      request: 'request'

    }
  },

  methods : {
    login() {
      axios.post('http://localhost:8000/controller/loginController.php', {
    mail: this.mail,
    password: this.password,
    request : this.request
  })
  .then(function (response) {
    console.log(response.data);
   
    
  })
  .catch(function (error) {
    console.log(error);
  });
      
    }
  }

}

</script>
<style scoped>
h1 {
  color: rgb(196, 210, 223);
}

#login {
  width: 100%;
  height: 100%;
  background-color: 
  rgb(103, 136, 136);
  display: flex;
  flex-direction: column;
  justify-content: center;

}

input {
  margin: 10px;
  padding: 12px;
  border-radius: 5px;
}

#forgot-password-link, #register-link {
  text-decoration-line: underline;
}

</style>

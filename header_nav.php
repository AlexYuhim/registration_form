<div class="container container_nav border rounded ">
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand " href="main.php">QUIZ</a>
    
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Переключатель навигации">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse " id="navbarSupportedContent">
      <!-- панель навигации -->
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item dropdown">
           <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Мероприятия
            </a>

          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
             <li class="nav-item ">
                <a class="dropdown-item link-dark  " aria-current="page" href="registration_form_for_event.php">Зарегистироваться на мероприятие</a>
                 </li>
                <li><a class="dropdown-item link-dark" href="allEvent.php">Все мероприятия</a></li>
                <li><a class="dropdown-item link-dark" href="archiveEvent.php">Архив мероприятий</a></li>
                <li><a class="dropdown-item" href="allUsersinEvent.php">Все участники</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="addEvent.php">Добавить мероприятие</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
           <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Пир любви
            </a>

          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                 
                  
                    <li><a class="dropdown-item link-dark" href="index.php">Анкета</a></li>
                    <li><a class="dropdown-item link-dark" href="quiz_admin.php">Ответы анкет</a></li>
                    
             
            </li>
          </ul>
        </li>
       
      </ul>
      <!-- вход регистрация -->
      <ul class=" nav navbar-rigth">
            <?
              if(isset($_SESSION['email']))
              {
                ?>
               <li class="nav-item">
              <a class="nav-link link-dark" href="admin/cabinet.php">Личный кабинет</a>
            </li>

            <li class="nav-item">
              <a class="nav-link link-dark" href="formRegistration.php?exit=1"></a>
              
            
            </li>
                <?
                
              } else
              {
            ?>
            <li class="nav-item">
              <a class="nav-link link-dark" href="formRegistration.php">Регистрации</a>
             
            </li>
              <a  class=" nav-link link-dark" href="formAuthorization.php">
              <svg class=" bi bi-trash" width="32" height="32" fill="">
                <use xlink:href="svg/bootstrap-icons.svg#box-arrow-in-right"/>
              </svg> 
              </a>
            </li>
            
            <?
              }
            ?>
          </ul>
    </div>
  </div>
</nav>


      
    </div>

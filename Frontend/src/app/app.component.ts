import { Component } from '@angular/core';
import { NavbarComponent } from './componenets/navbar/navbar.component';
import { FooterComponent } from './componenets/footer/footer.component';
import { RouterOutlet } from '@angular/router';

@Component({
  selector: 'app-root',
  //standalone: true,
  imports: [NavbarComponent, RouterOutlet, FooterComponent],
  templateUrl: './app.component.html'
})
export class AppComponent  {

}

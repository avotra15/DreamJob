import { CommonModule } from '@angular/common';
import { HttpClient } from '@angular/common/http';
import { Component, OnInit } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { Router, RouterModule } from '@angular/router';

@Component({
  selector: 'app-home',
  imports: [RouterModule, CommonModule, FormsModule],
  templateUrl: './home.component.html'
})
export class HomeComponent implements OnInit {
  listejobs: any[] = [];
  countrys: any[] = [];
  times: any[] = [];

  selectedcountry: string = '';
  selectedtimes: string = '';

  constructor (private http:HttpClient, private router:Router) {}

  ngOnInit(): void{
    this.loadJobs();
    this.loadCountry();
    this.loadTime();
  }

    loadJobs(): void {    
      this.http.get<any>('http://127.0.0.1:8000/listeJobs')
        .subscribe((response) => {
          console.log(response);
          this.listejobs = Array.isArray(response) ? response : response.data ?? [];
        });
    }

    loadCountry(): void {    
      this.http.get<any>('http://127.0.0.1:8000/country')
        .subscribe((response) => {
          this.countrys = Array.isArray(response) ? response : response.data ?? [];
        });
    }

    loadTime(): void {    
      this.http.get<any>('http://127.0.0.1:8000/time')
        .subscribe((response) => {
          this.times = Array.isArray(response) ? response : response.data ?? [];
        });
}

}

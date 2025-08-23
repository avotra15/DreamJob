import { CommonModule } from '@angular/common';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Component, OnInit } from '@angular/core';
import { Router, RouterModule } from '@angular/router';

@Component({
  selector: 'app-job-listings',
  imports: [RouterModule, CommonModule],
  templateUrl: './job-listings.component.html'
})
export class JobListingsComponent implements OnInit{
  listejobs: any[] = [];

  constructor (private http:HttpClient, private router:Router) {}

  ngOnInit(): void{
    this.loadJobs()
  }

  loadJobs(): void {    
    this.http.get<any[]>('http://127.0.0.1:8000/listeJobs')
      .subscribe((data) => {
      this.listejobs  = data;
    });
  }
}

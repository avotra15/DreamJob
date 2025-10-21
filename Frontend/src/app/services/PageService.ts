import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
    export class PageService {

    private pagechecked = 'http://127.0.0.1:8000/page/checked';

      constructor(private http:HttpClient) { }

        updateDroitPage(nom: string , id: number, isChecked: Boolean){
          
          const token = sessionStorage.getItem('token');

            const headers = new HttpHeaders({ 'Content-Type': 'application/json', 'Authorization': `Bearer ${token}` });

              const body = {
                nom_page: nom,
                role_id: id,
                action: isChecked,
              };

              return this.http.post<{ token: string }>(this.pagechecked, body, { headers })
        }
    }

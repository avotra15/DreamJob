import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ResultatComponent } from './resultat.component';

describe('ResultatComponent', () => {
  let component: ResultatComponent;
  let fixture: ComponentFixture<ResultatComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [ResultatComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ResultatComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

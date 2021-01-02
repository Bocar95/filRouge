import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AcceuilHeaderComponent } from './acceuil-header.component';

describe('AcceuilHeaderComponent', () => {
  let component: AcceuilHeaderComponent;
  let fixture: ComponentFixture<AcceuilHeaderComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ AcceuilHeaderComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(AcceuilHeaderComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

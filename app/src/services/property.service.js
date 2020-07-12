import ApiService from './api.service'

class PropertyService extends ApiService {
  constructor () {
    super({ segment: 'properties' })
  }

  list() {
    return this.client.get();
  }

  listUnhired() {
    return this.client.get('unhired');
  }

  store(data) {
    return this.client.post('', data);
  }

  destroy(id) {
    return this.client.delete(`${id}`);
  }

  
}

export default new PropertyService()

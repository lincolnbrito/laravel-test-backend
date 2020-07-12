import ApiService from './api.service'

class PropertyService extends ApiService {
  constructor () {
    super({ segment: 'properties' })
  }

  list() {
    return this.client.get();
  }

  store(data) {
    return this.client.post('', data);
  }
}

export default new PropertyService()
